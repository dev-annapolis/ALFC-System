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
use App\Models\ApAging;

use Carbon\Carbon;

class ApAgingController extends Controller
{
    //

    public function apAgingIndex()
    {
        return view('ap_aging.index');
    }

    public function apAgingData()
    {
        $data = ApAging::select(
            'ap_agings.id',
            'ap_agings.insurance_detail_id',
            'ap_agings.assured_name',
            'providers.name as providers',
            'ap_agings.remittance_number',
            'ap_agings.policy_number',
            'ap_agings.due_date_start',
            'ap_agings.due_date_end',
            'ap_agings.terms',
            'ap_agings.due_to_provider',
            'ap_agings.total_outstanding',
            'ap_agings.balance',
            'ap_agings.first_payment',
            'ap_agings.second_payment',
            'ap_agings.total_payment',
            'ap_agings.status',
        )
            ->leftJoin('providers', 'ap_agings.provider_id', '=', 'providers.id') // Assuming there's a 'providers' table for provider details
            ->get();

        // Log::info('AP Aging Data:', context: ['data' => $data]);
        return response()->json($data);
    }

    public function getAgingDetail($id)
    {
        // Fetch the full record by ID
        $agingRecord = ApAging::find($id);
        // Log::info($agingRecord);
        if ($agingRecord) {
            return response()->json([
                'success' => true,
                'data' => $agingRecord
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Record not found'
        ], 404);
    }
    public function saveAgingRecord(Request $request, $id)
    {
        // Get the authenticated user's username
        $username = auth()->user()->username; // Assuming you have a 'username' field in the users table

        // Get the current date in your desired format (MM/DD/YYYY)
        $currentDate = Carbon::now()->format('m/d/Y'); // Format as 'MM/DD/YYYY'

        // Retrieve the existing record
        $record = ApAging::find($id);

        if (!$record) {
            return response()->json(['success' => false, 'message' => 'Record not found']);
        }

        // Get the existing remittance number (if any)
        $existingRemittanceNumber = $record->remittance_number;

        // Concatenate the new remittance number with the username and date
        $remittanceNumber = $request->remittance_number;
        $newRemittanceNumber = $username . ': ' . $remittanceNumber . ' (' . $currentDate . ')';

        // If there is an existing remittance number, concatenate it with the new one, using "\n" to insert line breaks
        if ($existingRemittanceNumber) {
            $newRemittanceNumber = $existingRemittanceNumber . "\n" . $newRemittanceNumber;
        }
        // Prepare the data to save in the database
        $data = [
            'remittance_number' => $newRemittanceNumber,
            'first_payment' => $request->first_payment,
            'second_payment' => $request->second_payment,
            'balance' => $request->balance,
            'total_outstanding' => $request->total_outstanding,
        ];

        // Update the record in the database
        $record->update($data);

        return response()->json(['success' => true, 'message' => 'Record updated successfully']);
    }
    public function updateAging(Request $request, $id)
    {
        // Debugging: Log incoming data
        Log::info('Request Data: ', $request->all());

        // Validate the incoming data
        $request->validate([
            'remittance_number' => 'required|string',
            'first_payment' => 'required|numeric',
            'second_payment' => 'nullable|numeric',
            'balance' => 'required|numeric',
            'total_outstanding' => 'required|numeric',
        ]);

        // Find the aging record by ID
        $agingRecord = ApAging::find($id);

        if ($agingRecord) {
            // Update the record fields
            $agingRecord->remittance_number = $request->remittance_number;
            $agingRecord->first_payment = $request->first_payment;
            $agingRecord->second_payment = $request->second_payment;
            $agingRecord->balance = $request->balance;
            $agingRecord->total_outstanding = $request->total_outstanding;

            // Save the updated record
            $agingRecord->save();

            return response()->json([
                'success' => true,
                'message' => 'Record updated successfully'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Record not found'
        ], 404);
    }
}
