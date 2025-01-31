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
            'ar_agings.due_date_start',
            'ar_agings.due_date_end',
            'ar_agings.terms',
            'ar_agings.policy_number',
            'ar_agings.sale_date',
            'ar_agings.gross_premium',
            'ar_agings.total_outstanding',
            'ar_agings.balance',
            'teams.name as team',
            'mode_of_payments.name as mode_of_payment',
            DB::raw('DATEDIFF(CURDATE(), ar_agings.sale_date) as days_of_age'),
            'ar_agings.aging_due_days',
            'ar_agings.aging_description',

        )
            ->leftJoin('teams', 'ar_agings.team', '=', 'teams.id')
            ->leftJoin('mode_of_payments', 'ar_agings.mode_of_payment', '=', 'mode_of_payments.id')
            ->get();
        // Log::info('Aging Table Data:', context: ['data' => $data]);
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
            'ar_aging_pivots.over_under_payment',
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

        // Calculate the total paid amount and the sum of over_under_payment for the pivots
        $totalPaidAmount = ArAgingPivot::where('ar_aging_id', $id)->sum('paid_amount');
        $totalOverUnderPayment = ArAgingPivot::where('ar_aging_id', $id)->sum('over_under_payment');

        // Return the data as a JSON response
        return response()->json([
            'pivots' => $pivots,
            'summary' => $summary,
            'totalPaidAmount' => $totalPaidAmount,
            'totalOverUnderPayment' => $totalOverUnderPayment, // Include the sum of over_under_payment
        ]);
    }
    public function savePivotDetails(Request $request, $id)
    {
        // Log the incoming request data
        Log::info('Received data for saving pivot details:', $request->all());

        try {
            // Validate the request data
            $request->merge(['paid' => filter_var($request->input('paid'), FILTER_VALIDATE_BOOLEAN)]);

            $validated = $request->validate([
                'paid_amount' => 'nullable|string',
                'paid_schedule' => 'nullable|string',
                'payment_amount' => 'nullable|string',
                'payment_schedule' => 'nullable|string',
                'reference_number' => 'nullable|string',
                'ra_remarks' => 'nullable|string',
                'new_ra_remarks' => 'nullable|string',
                'new_tele_remarks' => 'nullable|string',
                'tele_remarks' => 'nullable|string',
                'paid' => 'required|boolean',
                'over_under_payment' => 'nullable|numeric',
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

        // Reset the fields before saving (clear the container)
        $pivot->paid_amount = null;
        $pivot->paid_schedule = null;
        $pivot->payment_amount = null;
        $pivot->payment_schedule = null;
        $pivot->reference_number = null;
        // $pivot->ra_remarks = null;
        // $pivot->tele_remarks = null;
        $pivot->paid = null;
        $pivot->over_under_payment = null;
        $pivot->paid = null;

        // Convert 'paid' to 1 or 0 before saving
        // $paid = $validated['paid'] ? 1 : 0; // Explicitly convert boolean to 1/0

        // Update the pivot with the validated data
        $pivot->paid_amount = $validated['paid_amount'];
        $pivot->paid_schedule = $validated['paid_schedule'];
        $pivot->payment_amount = $validated['payment_amount'];
        $pivot->payment_schedule = $validated['payment_schedule'];
        $pivot->over_under_payment = $validated['over_under_payment'];
        $pivot->reference_number = $validated['reference_number'];
        // $pivot->tele_remarks = $validated['tele_remarks'];
        // $pivot->ra_remarks = $validated['ra_remarks'];
        $pivot->paid = $validated['paid'];
        // Save the converted 'paid' value (1 or 0)

        if (!empty($validated['new_ra_remarks'])) {
            // Prepare the new remark
            $newRemark = auth()->user()->name . ' (' . now()->format('M j, Y ') . '): ' . $validated['new_ra_remarks'];

            // Check if 'ra_remarks' already contains the new remark
            if (strpos($pivot->ra_remarks, $newRemark) === false) {
                // If existing remarks are not empty, append the new remark with a newline
                $pivot->ra_remarks = empty($pivot->ra_remarks)
                    ? $newRemark
                    : $pivot->ra_remarks . "\n" . $newRemark;
            } else {
                // Log the redundant remark
                Log::info('Skipping redundant remark.', ['new_remark' => $newRemark]);
            }
        } else {
            // If 'new_ra_remarks' is empty, retain the current 'ra_remarks' value
            $pivot->ra_remarks = $validated['ra_remarks'] ?? $pivot->ra_remarks;
        }

        if (!empty($validated['new_tele_remarks'])) {
            // Prepare the new tele remark
            $newTeleRemark = auth()->user()->name . ' (' . now()->format('M j, Y ') . '): ' . $validated['new_tele_remarks'];

            // Check if 'tele_remarks' already contains the new remark
            if (strpos($pivot->tele_remarks, $newTeleRemark) === false) {
                // If existing tele remarks are not empty, append the new remark with a newline
                $pivot->tele_remarks = empty($pivot->tele_remarks)
                    ? $newTeleRemark
                    : $pivot->tele_remarks . "\n" . $newTeleRemark;
            } else {
                // Log the redundant tele remark
                Log::info('Skipping redundant tele remark.', ['new_tele_remark' => $newTeleRemark]);
            }
        } else {
            // If 'new_tele_remarks' is empty, retain the current 'tele_remarks' value
            $pivot->tele_remarks = $validated['tele_remarks'] ?? $pivot->tele_remarks;
        }


        // Log before saving
        Log::info('Saving updated pivot data:', ['pivot' => $pivot->toArray()]);

        // Save the updated pivot
        $pivot->save();

        // Retrieve the associated ArAging by its ID from the pivot's ar_aging_id
        $arAging = ArAging::where('id', $pivot->ar_aging_id)->first();

        if ($arAging) {
            // Calculate the total over_under_payment for all related pivots
            $totalOverUnderPayment = ArAgingPivot::where('ar_aging_id', $arAging->id)
                ->sum('over_under_payment');

            // Log the total over_under_payment
            Log::info('Total over/under payment:', ['total' => $totalOverUnderPayment]);

            // Retrieve the payment detail based on the insurance_details_id from the ArAging (related to the insurance_detail)
            $paymentDetail = PaymentDetail::where('insurance_detail_id', $arAging->insurance_detail_id)->first();

            if ($paymentDetail) {
                // Update the payment detail with the calculated over_under_payment
                $paymentDetail->over_under_payment = $totalOverUnderPayment;
                $paymentDetail->save(); // Save the updated payment detail
            } else {
                Log::warning('PaymentDetail not found for insurance_detail_id: ' . $arAging->insurance_detail_id);
            }

            // Update the balance of the related ArAging
            $totalPaidAmount = ArAgingPivot::where('ar_aging_id', $arAging->id)
                ->sum('paid_amount');

            // Compute the new balance
            $arAging->balance = $arAging->gross_premium - $totalPaidAmount;
            $arAging->last_paid_date = $pivot->paid_schedule = $validated['paid_schedule'];
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
