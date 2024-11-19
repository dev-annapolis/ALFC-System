<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AssuredDetail;
use Illuminate\Http\Request;
use App\Models\InsuranceDetail;
use App\Models\CommissionDetail;
use App\Models\InsuranceCommissioner;
use App\Models\CollectionDetail;
use App\Models\Assured;
use App\Models\PaymentDetail;
use App\Models\RolePermission;

use Log;
use Auth;
use DB;

use App\Models\Team;
use App\Models\SalesAssociate;
use App\Models\SalesManager;
use App\Models\Provider;
use App\Models\Product;
use App\Models\Subproduct;

class SalesReportController extends Controller
{
    public function salesReportIndex()
    {
        $teams = Team::where('status', 'active')->get();
        $sales_associates = SalesAssociate::where('status', 'active')->get();
        $sales_managers = SalesManager::where('status', 'active')->get();
        $providers = Provider::where('status', 'active')->get();
        $products = Product::where('status', 'active')->get();
        $subproducts = Subproduct::where('status', 'active')->get();

        return view('salesreport.index', compact('sales_associates', 'teams', 'sales_managers', 'providers', 'products', 'subproducts'));
    }

    public function salesReportData()
    {
        // Fetch the insurance details along with related data through nested relationships
        $insuranceDetails = InsuranceDetail::with([
            'assuredDetail', // Load assureds with their related assuredDetails
            'paymentDetail',
            'salesAssociate.team',
            // 'branchManager',
            'source',
            'subproduct',
            'provider',
        ])
            ->get()
            ->map(function ($insuranceDetail) {
                return [
                    'id' => $insuranceDetail->id ?? null,
                    'name' => $insuranceDetail->assuredDetail->name ?? null,
                    'contact_number' => $insuranceDetail->assuredDetail->contact_number ?? null,
                    'email' => $insuranceDetail->assuredDetail->email ?? null,
                    'issuance_code' => $insuranceDetail->issuance_code,
                    'sale_date' => $insuranceDetail->sale_date,
                    'good_as_sales_date' => $insuranceDetail->paymentDetail->good_as_sales_date ?? null,
                    'sales_associate' => $insuranceDetail->salesAssociate->name ?? null,
                    'sales_team' => $insuranceDetail->salesAssociate->team->name ?? null,
                    // 'branch_manager' => $insuranceDetail->branchManager->name ?? null,
                    'source' => $insuranceDetail->source->name ?? null,
                    'subproduct' => $insuranceDetail->subproduct->name ?? null,
                    'policy_inception_date' => $insuranceDetail->policy_inception_date ?? null,
                    'provider' => $insuranceDetail->provider->name ?? null,
                    'sale_status' => $insuranceDetail->insurance_status ?? null,
                ];
            })
            ->unique('id'); // Remove duplicates based on 'id' field

        // Return data as JSON response
        return response()->json($insuranceDetails->values()); // Reset keys after unique filtering
    }


    public function showInsuranceDetails($id)
    {
        $user = Auth::user();
        $role = $user->role;

        // Check if the role has the permission to view
        $permissions = RolePermission::where('role_id', $role->id)->get();

        if ($permissions->isEmpty()) {
            return response()->json(['message' => 'No permissions found'], 403);
        }

        $data = [];
        $tables = [
            'assured_details',
            'insurance_details',
            'commission_details',
            'insurance_commissioners',
            'collection_details',
            'payment_details',
        ];

        $insuranceDetail = InsuranceDetail::with([
            'assuredDetail',
            'salesAssociate',
            // 'branchManager',
            'product',
            'subproduct',
            'source',
            'sourceBranch',
            'ifGdfi',
            'area',
            'alfcBranch',
            'modeOfPayment',
            'provider',
            'paymentDetail',
            'commissionDetail',
            'collectionDetail.tele',
            'insuranceCommissioner.commissioner'
        ])
            ->where('insurance_details.id', $id)
            ->first();

        if (!$insuranceDetail) {
            return response()->json(['message' => 'Insurance details not found'], 404);
        }

        foreach ($tables as $tableName) {
            $tablePermissions = $permissions->where('table_name', $tableName)->where('can_view', 1);

            if ($tablePermissions->count() > 0) {
                $data[$tableName] = $this->getTableData($tableName, $insuranceDetail, $permissions);
            }
        }

        return response()->json($data, 200);
    }

    private function getTableData($tableName, $insuranceDetail, $permissions)
    {
        $tableData = $this->getDefaultTableData($tableName, $insuranceDetail);
        $editableColumns = [];

        foreach ($permissions as $permission) {
            if ($permission->table_name == $tableName) {
                foreach ($tableData as $key => $value) {
                    // Debug: Log each key's permission
                    \Log::info("Processing: Table {$tableName}, Key: {$key}, Permission: " . json_encode($permission));

                    // Mask columns where viewing is restricted
                    if ($permission->can_view == 0 && $permission->column_name == $key) {
                        $tableData[$key] = '*****';
                    }

                    // Mark columns as editable based on permissions
                    if ($permission->column_name == $key) {
                        $editableColumns[$key] = $permission->can_edit == 1;
                    }
                }

                // Special handling for nested data (e.g., `insurance_commissioners`)
                if ($tableName == 'insurance_commissioners') {
                    foreach ($tableData as &$commissionerData) {
                        foreach ($commissionerData as $commissionerKey => $commissionerValue) {
                            if ($permission->can_view == 0 && $permission->column_name == $commissionerKey) {
                                $commissionerData[$commissionerKey] = '*****';
                            }
                            if ($permission->column_name == $commissionerKey) {
                                $editableColumns[$commissionerKey] = $permission->can_edit == 1;
                            }
                        }
                    }
                }
            }
        }

        // Debug: Log final editable columns
        \Log::info("Editable columns for table {$tableName}: " . json_encode($editableColumns));

        return [
            'data' => $tableData,
            'editable' => $editableColumns,
        ];
    }



    private function getDefaultTableData($tableName, $insuranceDetail)
    {
        switch ($tableName) {
            case 'assured_details':
                return [
                    'name' => $insuranceDetail->assuredDetail->name ?? "N/A",
                    'address' => $insuranceDetail->assuredDetail->address ?? "N/A",
                    'contact_number' => $insuranceDetail->assuredDetail->contact_number ?? "N/A",
                    'other_contact_number' => $insuranceDetail->assuredDetail->other_contact_number ?? "N/A",
                    'email' => $insuranceDetail->assuredDetail->email ?? "N/A",
                    'facebook_account' => $insuranceDetail->assuredDetail->facebook_account ?? "N/A",
                    'viber_account' => $insuranceDetail->assuredDetail->viber_account ?? "N/A",
                    'nature_of_business' => $insuranceDetail->assuredDetail->nature_of_business ?? "N/A",
                    'other_assets' => $insuranceDetail->assuredDetail->other_assets ?? "N/A",
                    'other_source_of_business' => $insuranceDetail->assuredDetail->other_source_of_business ?? "N/A"
                ];
            case 'insurance_details':
                return [
                    'name' => $insuranceDetail->assuredDetail->name ?? "N/A",
                    'issuance_code' => $insuranceDetail->issuance_code ?? "N/A",
                    'team_name' => $insuranceDetail->team->name ?? "N/A",
                    'sale_date' => $insuranceDetail->sale_date ?? "N/A",
                    'sales_associate_name' => $insuranceDetail->salesAssociate->name ?? "N/A",
                    'sales_manager_name' => $insuranceDetail->salesManager->name ?? "N/A",
                    'classification' => $insuranceDetail->classification ?? "N/A",
                    'insurance_status' => $insuranceDetail->insurance_status ?? "N/A",
                    'book_number' => $insuranceDetail->book_number ?? "N/A",
                    'filing_number' => $insuranceDetail->filing_number ?? "N/A",
                    'database_remarks' => $insuranceDetail->database_remarks ?? "N/A",
                    'pid_received_date' => $insuranceDetail->pid_received_date ?? "N/A",
                    'pid_completion_date' => $insuranceDetail->pid_completion_date ?? "N/A",
                    'pid_status' => $insuranceDetail->pid_status ?? "N/A",
                    'provider_name' => $insuranceDetail->provider->name ?? "N/A",
                    'product_name' => $insuranceDetail->product->name ?? "N/A",
                    'subproduct_name' => $insuranceDetail->subproduct->name ?? "N/A",
                    'product_type' => $insuranceDetail->product_type ?? "N/A",
                    'source_name' => $insuranceDetail->source->name ?? "N/A",
                    'source_branch_name' => $insuranceDetail->sourceBranch->name ?? "N/A",
                    'if_gdfi' => $insuranceDetail->ifGdfi->name ?? "N/A",
                    'mortgagee' => $insuranceDetail->mortgagee ?? "N/A",
                    'area_name' => $insuranceDetail->area->name ?? "N/A",
                    'alfc_branch_name' => $insuranceDetail->alfcBranch->name ?? "N/A",
                    'policy_number' => $insuranceDetail->policy_number ?? "N/A",
                    'plate_conduction_number' => $insuranceDetail->plate_conduction_number ?? "N/A",
                    'description' => $insuranceDetail->description ?? "N/A",
                    'policy_inception_date' => $insuranceDetail->policy_inception_date ?? "N/A",
                    'expiry_date' => $insuranceDetail->expiry_date ?? "N/A",
                    'policy_expiration_aging' => $insuranceDetail->policy_expiration_aging ?? "N/A",
                    'loan_amount' => $insuranceDetail->loan_amount ?? "N/A",
                    'total_sum_insured' => $insuranceDetail->total_sum_insured ?? "N/A",
                    'mode_of_payment_name' => $insuranceDetail->modeOfPayment->name ?? "N/A"
                ];
            case 'commission_details':
                return [
                    'gross_premium' => $insuranceDetail->commissionDetail->gross_premium ?? "N/A",
                    'discount' => $insuranceDetail->commissionDetail->discount ?? "N/A",
                    'gross_premium_net_discounted' => $insuranceDetail->commissionDetail->gross_premium_net_discounted ?? "N/A",
                    'amount_due_to_provider' => $insuranceDetail->commissionDetail->amount_due_to_provider ?? "N/A",
                    'full_commission' => $insuranceDetail->commissionDetail->full_commission ?? "N/A",
                    'travel_incentives' => $insuranceDetail->commissionDetail->travel_incentives ?? "N/A",
                    'offsetting' => $insuranceDetail->commissionDetail->offsetting ?? "N/A",
                    'promo' => $insuranceDetail->commissionDetail->promo ?? "N/A",
                    'total_commission' => $insuranceDetail->commissionDetail->total_commission ?? "N/A",
                    'vat' => $insuranceDetail->commissionDetail->vat ?? "N/A",
                    'sales_credit' => $insuranceDetail->commissionDetail->sales_credit ?? "N/A",
                    'sales_credit_percent' => $insuranceDetail->commissionDetail->sales_credit_percent ?? "N/A",
                    'comm_deduct' => $insuranceDetail->commissionDetail->comm_deduct ?? "N/A"
                ];
            case 'insurance_commissioners':
                $commissionersData = [];
                foreach ($insuranceDetail->insuranceCommissioner as $commissionerDetail) {
                    $commissionersData[] = [
                        'commissioner_title' => $commissionerDetail->commissioner->name ?? "N/A",
                        'commissioner_name' => $commissionerDetail->commissioner_name ?? "N/A",
                        'amount' => $commissionerDetail->amount ?? "N/A"
                    ];
                }

                return $commissionersData;
            case 'collection_details':
                return [
                    'insurance_type' => $insuranceDetail->collectionDetail->insurance_type ?? "N/A",
                    'sale_status' => $insuranceDetail->collectionDetail->sale_status ?? "N/A",
                    'tele_name' => $insuranceDetail->collectionDetail->tele->name ?? "N/A",
                    'due_date' => $insuranceDetail->collectionDetail->due_date ?? "N/A",
                    'paid_terms' => $insuranceDetail->collectionDetail->paid_terms ?? "N/A",
                    'payment_remarks' => $insuranceDetail->collectionDetail->payment_remarks ?? "N/A",
                    'account_status' => $insuranceDetail->collectionDetail->account_status ?? "N/A",
                    'payment_ptp_declared' => $insuranceDetail->collectionDetail->payment_ptp_declared ?? "N/A",
                    'payment_center' => $insuranceDetail->collectionDetail->payment_center ?? "N/A",
                    'reference_number' => $insuranceDetail->collectionDetail->reference_number ?? "N/A",
                    'date_on_receipt_abstract' => $insuranceDetail->collectionDetail->date_on_receipt_abstract ?? "N/A",
                    'contact_number_verification' => $insuranceDetail->collectionDetail->contact_number_verification ?? "N/A"
                ];
            case 'payment_details':
                return [
                    'payment_terms' => $insuranceDetail->paymentDetail->payment_terms ?? "N/A",
                    'date_of_good_as_sales' => $insuranceDetail->paymentDetail->date_of_good_as_sales ?? "N/A",
                    'due_date_start' => $insuranceDetail->paymentDetail->due_date_start ?? "N/A",
                    'due_date_end' => $insuranceDetail->paymentDetail->due_date_end ?? "N/A",
                    'schedule_first_payment' => $insuranceDetail->paymentDetail->first_payment_schedule ?? "N/A",
                    'amount_first_payment' => $insuranceDetail->paymentDetail->first_payment_amount ?? "N/A",
                    'schedule_second_payment' => $insuranceDetail->paymentDetail->second_payment_schedule ?? "N/A",
                    'amount_second_payment' => $insuranceDetail->paymentDetail->second_payment_amount ?? "N/A",
                    'schedule_third_payment' => $insuranceDetail->paymentDetail->third_payment_schedule ?? "N/A",
                    'amount_third_payment' => $insuranceDetail->paymentDetail->third_payment_amount ?? "N/A",
                    'schedule_fourth_payment' => $insuranceDetail->paymentDetail->fourth_payment_schedule ?? "N/A",
                    'amount_fourth_payment' => $insuranceDetail->paymentDetail->fourth_payment_amount ?? "N/A",
                    'schedule_fifth_payment' => $insuranceDetail->paymentDetail->fifth_payment_schedule ?? "N/A",
                    'amount_fifth_payment' => $insuranceDetail->paymentDetail->fifth_payment_amount ?? "N/A",
                    'schedule_sixth_payment' => $insuranceDetail->paymentDetail->sixth_payment_schedule ?? "N/A",
                    'amount_sixth_payment' => $insuranceDetail->paymentDetail->sixth_payment_amount ?? "N/A",
                    'schedule_seventh_payment' => $insuranceDetail->paymentDetail->seventh_payment_schedule ?? "N/A",
                    'amount_seventh_payment' => $insuranceDetail->paymentDetail->seventh_payment_amount ?? "N/A",
                    'schedule_eighth_payment' => $insuranceDetail->paymentDetail->eight_payment_schedule ?? "N/A",
                    'amount_eighth_payment' => $insuranceDetail->paymentDetail->eight_payment_amount ?? "N/A",
                    'provision_receipt' => $insuranceDetail->paymentDetail->provision_receipt ?? "N/A",
                    'initial_payment' => $insuranceDetail->paymentDetail->initial_payment ?? "N/A",
                    'for_billing' => $insuranceDetail->paymentDetail->for_billing ?? "N/A",
                    'over_under_payment' => $insuranceDetail->paymentDetail->over_under_payment ?? "N/A",
                    'payment_status' => $insuranceDetail->paymentDetail->payment_status ?? "N/A",
                ];
            default:
                return [];

        }
    }

    public function updateInsuranceDetail(Request $request)
    {
        Log::info($request->all());

        $tableName = $request->input('table');
        $key = $request->input('field_name');
        $newValue = $request->input('value');
        $insuranceDetailId = $request->input('insurance_detail_id');

        // Retrieve the insurance detail with related models
        $insuranceDetail = InsuranceDetail::with([
            'assuredDetail',
            'salesAssociate',
            'salesManager',
            'product',
            'subproduct',
            'source',
            'sourceBranch',
            'ifGdfi',
            'area',
            'alfcBranch',
            'modeOfPayment',
            'provider',
            'paymentDetail',
            'commissionDetail',
            'collectionDetail.tele',
            'insurancecommissioner.commissioner',
            'team', // Ensure team relationship is loaded
        ])->find($insuranceDetailId);

        // Ensure the insurance detail record exists
        if (!$insuranceDetail) {
            return response()->json(['error' => 'Insurance detail not found'], 404);
        }

        // Handle updates based on table name
        switch ($tableName) {
            case 'assured_details':
                $assuredDetail = $insuranceDetail->assuredDetail;
                if ($assuredDetail) {
                    $assuredDetail->$key = $newValue;
                    $assuredDetail->save();

                    return response()->json(['success' => 'Field updated successfully', 'updatedData' => $assuredDetail]);
                } else {
                    return response()->json(['error' => 'Assured record not found'], 404);
                }

                case 'insurance_details':
                    if ($key === 'sales_associate_name') {
                        $insuranceDetail->sales_associate_id = $newValue;
                        $insuranceDetail->save();
                
                        $salesAssociate = SalesAssociate::find($newValue);
                        if ($salesAssociate) {
                            return response()->json([
                                'success' => 'Field updated successfully',
                                'updatedData' => $insuranceDetail,
                                'updatedName' => $salesAssociate->name // Include the name of the sales associate
                            ]);
                        } else {
                            return response()->json(['error' => 'Sales associate not found'], 404);
                        }
                    }
                
                    if ($key === 'team_name') {
                        $insuranceDetail->team_id = $newValue;
                        $insuranceDetail->save();
                
                        $team = Team::find($newValue);
                        if ($team) {
                            return response()->json([
                                'success' => 'Field updated successfully',
                                'updatedData' => $insuranceDetail,
                                'updatedName' => $team->name // Include the name of the team
                            ]);
                        } else {
                            return response()->json(['error' => 'Team not found'], 404);
                        }
                    }
                
                    if ($key === 'sales_manager_name') {
                        $insuranceDetail->sales_manager_id = $newValue;
                        $insuranceDetail->save();
                
                        $salesManager = SalesManager::find($newValue);
                        if ($salesManager) {
                            return response()->json([
                                'success' => 'Field updated successfully',
                                'updatedData' => $insuranceDetail,
                                'updatedName' => $salesManager->name // Include the name of the sales manager
                            ]);
                        } else {
                            return response()->json(['error' => 'Sales manager not found'], 404);
                        }
                    }
                
                    if ($key === 'provider_name') {
                        $insuranceDetail->provider_id = $newValue;
                        $insuranceDetail->save();
                
                        $provider = Provider::find($newValue);
                        if ($provider) {
                            return response()->json([
                                'success' => 'Field updated successfully',
                                'updatedData' => $insuranceDetail,
                                'updatedName' => $provider->name // Include the name of the provider
                            ]);
                        } else {
                            return response()->json(['error' => 'Provider not found'], 404);
                        }
                    }
                
                    if ($key === 'product_name') {
                        $insuranceDetail->product_id = $newValue;
                        $insuranceDetail->save();
                
                        $product = Product::find($newValue);
                        if ($product) {
                            return response()->json([
                                'success' => 'Field updated successfully',
                                'updatedData' => $insuranceDetail,
                                'updatedName' => $product->name // Include the name of the product
                            ]);
                        } else {
                            return response()->json(['error' => 'Product not found'], 404);
                        }
                    }
                
                    if ($key === 'subproduct_name') {
                        $insuranceDetail->subproduct_id = $newValue;
                        $insuranceDetail->save();
                
                        $subproduct = Subproduct::find($newValue);
                        if ($subproduct) {
                            return response()->json([
                                'success' => 'Field updated successfully',
                                'updatedData' => $insuranceDetail,
                                'updatedName' => $subproduct->name // Include the name of the subproduct
                            ]);
                        } else {
                            return response()->json(['error' => 'Subproduct not found'], 404);
                        }
                    }
                
                    if (isset($insuranceDetail->$key)) {
                        $insuranceDetail->$key = $newValue;
                        $insuranceDetail->save();
                
                        return response()->json(['success' => 'Field updated successfully', 'updatedData' => $insuranceDetail]);
                    }
                
                    return response()->json(['error' => 'Field name does not exist in the table or its relations'], 400);
                

            default:
                return response()->json(['error' => 'Invalid table or field name'], 400);
        }
    }






}





