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

        return view('ra.index', compact('teams','commissioners'));
    }

    public function raIndexData(Request $request)
    {
        $teamIds = $request->input('team_ids', []);

        // Query logic (replace with your actual query)
        $insuranceDetails = InsuranceDetail::with(['assuredDetail', 'paymentDetail', 'commissionDetail'])
            ->when(!empty($teamIds), function ($query) use ($teamIds) {
                $query->whereIn('team_id', $teamIds);
            })
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
                'gross_premium' => $insuranceDetail->commissionDetail->gross_premium ?? 'N/A',
                'discount' => $insuranceDetail->commissionDetail->discount ?? 'N/A',
                'amount_due_to_provider' => $insuranceDetail->commissionDetail->amount_due_to_provider ?? 'N/A',
                'sales_associate' => $insuranceDetail->salesAssociate->name ?? null,
                'sales_team' => $insuranceDetail->team->name ?? null,
                'sales_credit' => $insuranceDetail->commissionDetail->sales_credit ?? 'N/A',
                'sales_credit_percent' => $insuranceDetail->commissionDetail->sales_credit_percent ?? 'N/A',
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





}
