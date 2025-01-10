<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Log;
use DB;
use App\Models\AssuredDetail;
use App\Models\InsuranceDetail;
use App\Models\CommissionDetail;
use App\Models\PaymentDetail;
use App\Models\InsuranceCommissioner;
use App\Models\SalesAssociate;
use App\Models\SalesManager;
use App\Models\Provider;
use App\Models\Product;
use App\Models\Subproduct;
use App\Models\Source;
use App\Models\SourceBranch;
use App\Models\IfGdfi;
use App\Models\Area;
use App\Models\AlfcBranch;
use App\Models\Team;
use App\Models\ModeOfPayment;
use App\Models\Commissioner;
use App\Models\ArAging;
use App\Models\ArAgingPivot;
use App\Helpers\DateHelper; // Use the helper if in a helper file or service

class AgingController extends Controller
{
    public function agingIndex()
    {
        return view('aging.index');
    }
    public function agingTableData()
    {
        $data = ArAging::select(
            'ar_agings.id',
            'ar_agings.insurance_detail_id',
            'ar_agings.issuance_code',
            'ar_agings.name',
            // Concatenate the first and last payment_schedule
            DB::raw('CONCAT(
                (SELECT payment_schedule FROM ar_aging_pivots WHERE ar_aging_id = ar_agings.id ORDER BY payment_schedule ASC LIMIT 1),
                " to ",
                (SELECT payment_schedule FROM ar_aging_pivots WHERE ar_aging_id = ar_agings.id ORDER BY payment_schedule DESC LIMIT 1)
            ) as due_date'),
            'ar_agings.terms',
            'ar_agings.policy_number',
            'ar_agings.sale_date',
            'ar_agings.gross_premium',
            'ar_agings.total_outstanding',
            'ar_agings.balance',
            'teams.name as team',
            'mode_of_payments.name as mode_of_payment' // Fetch the name of the payment mode
        )
            ->leftJoin('teams', 'ar_agings.team', '=', 'teams.id') // Join with teams table
            ->leftJoin('mode_of_payments', 'ar_agings.mode_of_payment', '=', 'mode_of_payments.id') // Join with mode_of_payments table
            ->get();



        // Return JSON response
        return response()->json($data);
    }

    public function getArAgingPivots($id)
    {
        // Retrieve selected fields from ArAgingPivot and related fields from ar_agings table
        $pivots = ArAgingPivot::select(
            'ar_aging_pivots.id',
            'ar_aging_pivots.label',
            'ar_aging_pivots.payment_amount',
            'ar_aging_pivots.payment_schedule',
            'ar_aging_pivots.paid_amount',
            'ar_aging_pivots.paid_schedule',
            'ar_aging_pivots.reference_number',
            'ar_aging_pivots.ra_remarks',
            'ar_aging_pivots.tele_remarks',
            'ar_aging_pivots.paid',
            'ar_agings.gross_premium',
            'ar_agings.total_outstanding',
            'ar_agings.balance'
        )
            ->join('ar_agings', 'ar_agings.id', '=', 'ar_aging_pivots.ar_aging_id') // Join with ar_agings table
            ->where('ar_aging_pivots.ar_aging_id', $id) // Filter by the given AR Aging ID
            ->get();

        // Retrieve summary fields for the given AR Aging ID
        $summary = ArAging::select(
            'gross_premium',
            'total_outstanding',
            'balance'
        )
            ->where('id', $id) // Match the given ID in ArAging table
            ->first(); // Fetch the single matching record
        $totalPaidAmount = ArAgingPivot::where('ar_aging_id', $id)->sum('paid_amount');

        // Return the data as a JSON response
        return response()->json([
            'pivots' => $pivots,
            'summary' => $summary,
            'totalPaidAmount' => $totalPaidAmount
        ]);
    }
    public function savePivotDetails(Request $request, $id)
    {
        // Log the incoming request data
        Log::info('Received data for saving pivot details:', $request->all());

        try {
            // Validate the request data
            $validated = $request->validate([
                'paid_amount' => 'nullable|string',
                'paid_schedule' => 'nullable|string',
                'payment_amount' => 'nullable|string',
                'payment_schedule' => 'nullable|string',
                'reference_number' => 'nullable|string',
                'ra_remarks' => 'nullable|string',
                'tele_remarks' => 'nullable|string',
                'paid' => 'nullable|in:true,false,1,0', // Accept boolean-like strings
            ]);

            // Log validation success
            Log::info('Validation passed for pivot details.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed for pivot details.', ['errors' => $e->errors()]);
            return response()->json(['error' => 'Validation failed', 'messages' => $e->errors()], 422);
        }

        // Find the pivot by ID
        $pivot = ArAgingPivot::find($id);

        if (!$pivot) {
            Log::warning('Pivot not found with ID: ' . $id);
            return response()->json(['error' => 'Pivot not found'], 404);
        }

        // Log the pivot data before updating
        Log::info('Pivot found. Updating with new data.', ['pivot' => $pivot]);

        // Convert 'paid' to 1 or 0 before saving
        $paid = $validated['paid'] ? 1 : 0;  // Convert true/false to 1/0

        // Update the pivot with the validated data
        $pivot->paid_amount = $validated['paid_amount'];
        $pivot->paid_schedule = $validated['paid_schedule'];
        $pivot->payment_amount = $validated['payment_amount'];
        $pivot->payment_schedule = $validated['payment_schedule'];
        $pivot->reference_number = $validated['reference_number'];
        $pivot->ra_remarks = $validated['ra_remarks'];
        $pivot->tele_remarks = $validated['tele_remarks'];
        $pivot->paid = $paid; // Save the converted 'paid' value (1 or 0)

        // Log before saving
        Log::info('Saving updated pivot data:', ['pivot' => $pivot->toArray()]);

        // Save the updated pivot
        $pivot->save();

        // Update the balance of the related ArAging
        $arAging = ArAging::find($pivot->ar_aging_id); // Assuming `ar_aging_id` exists in pivot table
        if ($arAging) {
            // Calculate the total paid amount for all related pivots
            $totalPaidAmount = ArAgingPivot::where('ar_aging_id', $arAging->id)
                ->sum('paid_amount');

            // Compute the new balance
            $arAging->balance = $arAging->gross_premium - $totalPaidAmount;

            // Ensure balance is not negative
            $arAging->balance = max($arAging->balance, 0);
            $arAging->total_outstanding = $totalPaidAmount;
            // Save the updated balance
            $arAging->save();

            // Log the balance update
            Log::info('ArAging balance updated.', [
                'ar_aging_id' => $arAging->id,
                'new_balance' => $arAging->balance,
                'gross_premium' => $arAging->gross_premium,
                'total_paid_amount' => $totalPaidAmount,
            ]);
        } else {
            Log::warning('ArAging not found for pivot with ar_aging_id: ' . $pivot->ar_aging_id);
        }

        // Log success
        Log::info('Pivot details updated successfully.');

        // Return success response
        return response()->json(['success' => true]);
    }


}
