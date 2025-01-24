<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\SalesAssociate;
use App\Models\SalesManager;
use App\Models\Provider;
use App\Models\Product;
use App\Models\Subproduct;
use App\Models\Source;
use App\Models\Sourcebranch;
use App\Models\IfGdfi;
use App\Models\Area;
use App\Models\AlfcBranch;
use App\Models\ModeOfPayment;
use App\Models\Tele;
use App\Models\Commissioner;
use App\Models\InsuranceCommissioner;
use App\Models\InsuranceDetail;
use App\Models\RolePermission;
use App\Models\PaymentDetail;
use App\Models\ArAging;
use App\Models\ArAgingPivot;
use Illuminate\Http\Request;
use Log;
use Auth;
use DB;
class RevenueAssistantController extends Controller
{
    public function RevenueAssistantIndex()
    {
        $teams = Team::all();
        $commissioners = Commissioner::all();

        return view('ra.index', compact('teams', 'commissioners'));
    }

    public function raIndexData(Request $request)
    {
        $teamIds = $request->input('team_ids', []);

        // Query logic (replace with your actual query)
        $insuranceDetails = InsuranceDetail::with(['assuredDetail', 'paymentDetail', 'commissionDetail'])
            ->when(!empty($teamIds), function ($query) use ($teamIds) {
                $query->whereIn('team_id', $teamIds);
            })
            ->where('verification_status', 'for_ra_verification')
            ->get();

        // Prepare data for DataTable
        $data = $insuranceDetails->map(function ($insuranceDetail) {
            return [
                'id' => $insuranceDetail->id,
                'issuance_code' => $insuranceDetail->issuance_code ?? 'N/A',
                'name' => $insuranceDetail->assuredDetail->name ?? 'N/A',
                'policy_number' => $insuranceDetail->policy_number ?? 'N/A',
                'plate_conduction_number' => $insuranceDetail->plate_conduction_number ?? 'N/A',
                'mode_of_payment' => $insuranceDetail->modeOfPayment->name ?? 'N/A',
                'pr_number' => $insuranceDetail->paymentDetail->provision_receipt ?? 'N/A',
                'gross_premium' => $insuranceDetail->paymentDetail->gross_premium ?? 'N/A',
                'discount' => $insuranceDetail->paymentDetail->discount ?? 'N/A',
                'amount_due_to_provider' => $insuranceDetail->paymentDetail->amount_due_to_provider ?? 'N/A',
                'sales_associate' => $insuranceDetail->salesAssociate->name ?? null,
                'sales_team' => $insuranceDetail->team->name ?? null,
                'sales_credit' => $insuranceDetail->paymentDetail->sales_credit ?? 'N/A',
                'sales_credit_percent' => $insuranceDetail->paymentDetail->sales_credit_percent ?? 'N/A',
                'sale_date' => $insuranceDetail->sale_date ?? 'N/A',
                'date_of_good_as_sales' => $insuranceDetail->paymentDetail->date_of_good_as_sales ?? 'N/A',
                'status' => $insuranceDetail->insurance_status ?? 'N/A',
                'ra_comments' => $insuranceDetail->ra_comments ?? ' ',

            ];
        });

        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => $insuranceDetails->count(),
            'recordsFiltered' => $insuranceDetails->count(),
            'data' => $data,
        ]);
    }

    public function getDataById($insuranceDetailId)
    {
        Log::info("Received ID: {$insuranceDetailId}");

        // Validate the ID input
        if (!$insuranceDetailId) {
            return response()->json([
                'success' => false,
                'message' => 'Insurance Detail ID is required',
            ], 400);
        }

        // Fetch the ArAging and its related ArAgingPivot with the 'current' label
        $arAging = ArAging::where('insurance_detail_id', $insuranceDetailId)->first();

        $currentPaymentAmount = 0;
        if ($arAging) {
            $arAgingPivot = ArAgingPivot::where('ar_aging_id', $arAging->id)
                ->where('label', 'current') // Only update rows where label = 'current'
                ->first();

            if ($arAgingPivot) {
                $currentPaymentAmount = $arAgingPivot->payment_amount ?? 0;
            }
        }

        // Fetch the insurance detail
        $insuranceDetail = InsuranceDetail::find($insuranceDetailId);

        if (!$insuranceDetail) {
            return response()->json([
                'success' => false,
                'message' => 'Insurance detail not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $insuranceDetail->id,
                'issuance_code' => $insuranceDetail->issuance_code ?? 'N/A',
                'payment_amount' => $currentPaymentAmount,
            ],
        ]);
    }





    public function viewCommission($insuranceDetailsId)
    {
        $commissioners = InsuranceCommissioner::with('commissioner')
            ->where('insurance_detail_id', $insuranceDetailsId)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $commissioners->map(function ($commissionerDetail) {
                return [
                    'id' => $commissionerDetail->id ?? " ",
                    'commissioner_id' => $commissionerDetail->commissioner_id ?? " ",
                    'commissioner_title' => $commissionerDetail->commissioner->name ?? "N/A",
                    'commissioner_name' => $commissionerDetail->commissioner_name ?? " ",
                    'amount' => $commissionerDetail->amount ?? "N/A",
                ];
            }),
        ]);
    }

    public function updateCommission($insuranceDetailsId, Request $request)
    {
        $updatedData = $request->input('commissioners');
        $existingIds = InsuranceCommissioner::where('insurance_detail_id', $insuranceDetailsId)
            ->pluck('id')
            ->toArray();

        $totalAmount = 0;

        foreach ($updatedData as $commission) {
            if (!empty($commission['id'])) {
                // Update existing record
                $commissioner = InsuranceCommissioner::find($commission['id']);
                $commissioner->update([
                    'commissioner_id' => $commission['commissioner_id'],
                    'commissioner_name' => $commission['commissioner_name'],
                    'amount' => $commission['amount'],
                ]);
                $processedIds[] = $commissioner->id; // Track this ID
            } else {
                // Add new record
                $newCommissioner = InsuranceCommissioner::create([
                    'insurance_detail_id' => $insuranceDetailsId,
                    'commissioner_id' => $commission['commissioner_id'],
                    'commissioner_name' => $commission['commissioner_name'],
                    'amount' => $commission['amount'],
                ]);
                $processedIds[] = $newCommissioner->id; // Track new ID
            }
            $totalAmount += $commission['amount'];
        }

        $toDelete = array_diff($existingIds, $processedIds);
        InsuranceCommissioner::destroy($toDelete);

        return response()->json([
            'success' => true,
            'message' => 'Changes saved successfully! Total: ' . $totalAmount,
        ]);
    }



    public function postComment(Request $request, $id)
    {
        // Validate the incoming comment
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        // Find the insurance detail by ID
        $insuranceDetail = InsuranceDetail::findOrFail($id);

        // Append the new comment to the existing comments (or initialize it if empty)
        $existingComments = $insuranceDetail->ra_comments ?? ''; // Existing comments, if any
        $newComment = auth()->user()->name . ' (' . now()->format('M j, Y') . '): ' . $request->comment;
        $insuranceDetail->ra_comments = trim($existingComments . "\n" . $newComment);

        // Save the updated comments
        $insuranceDetail->save();

        return response()->json([
            'success' => true,
            'message' => 'Comment added successfully!',
            'ra_comments' => $insuranceDetail->ra_comments, // Return updated comments for the frontend
        ]);
    }
    public function verifyInsuranceDetail(Request $request, $id)
    {
        // Validate incoming data
        $request->validate([
            'initial_payment' => 'required|numeric',
            'for_billing' => 'required|string|max:255',
            'over_under_payment' => 'required|string|max:255',
            'date_of_good_as_sales' => 'required|date',
            'payment_status' => 'required|string|max:255',
            'verification_status' => 'required|string|max:255',
            'comment' => 'required|string|max:1000',
        ]);

        // Find the insurance detail by ID
        $insuranceDetail = InsuranceDetail::findOrFail($id);

        // Update insurance_details fields
        $insuranceDetail->verification_status = $request->verification_status;
        $existingComments = $insuranceDetail->ra_comments ?? ''; // Existing comments, if any
        $newComment = auth()->user()->name . ' (' . now()->format('M j, Y') . '): ' . $request->comment;
        $insuranceDetail->ra_comments = trim($existingComments . "\n" . $newComment);
        $insuranceDetail->save(); // Save changes to the insurance_details table

        // Update the related payment_details record
        $paymentDetail = PaymentDetail::where('insurance_detail_id', $id)->first();

        if ($paymentDetail) {
            $paymentDetail->for_billing = $request->for_billing;
            $paymentDetail->date_of_good_as_sales = $request->date_of_good_as_sales;
            $paymentDetail->payment_status = $request->payment_status;
            $paymentDetail->initial_payment = $request->initial_payment;

            // Update the ArAgingPivot table based on ar_aging_id
            $arAging = ArAging::where('insurance_detail_id', $id)->first();
            if ($arAging) {
                $arAgingPivot = ArAgingPivot::where('ar_aging_id', $arAging->id)
                    ->where('label', 'current') // Only update rows where label = 'current'
                    ->first();

                if ($arAgingPivot) {
                    $arAgingPivot->paid_amount = $request->initial_payment; // Set paid_amount to initial_payment
                    $arAgingPivot->paid_schedule = $request->date_of_good_as_sales; // Set paid_schedule to date_of_good_as_sales
                    $arAgingPivot->over_under_payment = $request->over_under_payment;
                    $arAgingPivot->ra_remarks = trim($existingComments . "\n" . $newComment);
                    $arAgingPivot->paid = true; // Set paid_status to true (boolean)
                    $arAgingPivot->save(); // Save changes to the ArAgingPivot table
                }

                $totalOverUnderPayment = ArAgingPivot::where('ar_aging_id', $arAging->id)
                    ->sum('over_under_payment');
                Log::info($totalOverUnderPayment);

                $paymentDetail->over_under_payment = $totalOverUnderPayment;

                // Calculate the total paid amount for the AR Aging
                $totalPaidAmount = ArAgingPivot::where('ar_aging_id', $arAging->id)
                    ->sum('paid_amount');

                // Compute the new balance
                $arAging->balance = $arAging->gross_premium - $totalPaidAmount;

                // Ensure balance is not negative
                $arAging->balance = max($arAging->balance, 0);

                // Update the total outstanding
                $arAging->total_outstanding = $totalPaidAmount;
                $arAging->last_paid_date = $request->date_of_good_as_sales;
                // Save changes to the ArAging table
                $arAging->save();
            }

            $paymentDetail->save(); // Save changes to the payment_details table
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Payment detail not found for this insurance detail!',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Insurance detail, payment detail, AR aging pivot, and AR aging table updated successfully!',
        ]);
    }






}
