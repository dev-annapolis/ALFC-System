<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\RolePermission;

class UniversalTableController extends Controller
{
    public function showRecordsS()
    {
        $tables = [
            'assured_details' => [
                'address',
                'contact_number',
                'email',
                'other_contact_number',
                'facebook_account',
                'viber_account',
                'nature_of_business',
                'other_assets',
                'remarks',
            ],
            'assureds' => [
                'name',
                'assured_detail_id',
            ],
            'insurance_details' => [
                'issuance_code',
                'assured_id',
                'sales_associate_id',
                'sale_date',
                'classification',
                'insurance_type',
                'sale_status',
                'branch_manager_id',
                'legal_representative_name',
                'legal_supervisor_name',
                'assigned_atty_one',
                'assigned_atty_two',
                'collection_gm',
                'product_id',
                'subproduct_id',
                'source_id',
                'source_branch_id',
                'if_gdfi_id',
                'mortgagee',
                'area_id',
                'alfc_branch_id',
                'loan_amount',
                'total_sum_insured',
                'policy_number',
                'policy_inception_date',
                'expiry_date',
                'plate_conduction_number',
                'description',
                'policy_expiration_aging',
                'book_number',
                'filing_number',
                'pid_received_date',
                'pid_completion_date',
                'remarks',
                'mode_of_payment_id',
                'provider_id',
            ],
            'payment_details' => [
                'insurance_detail_id',
                'payment_terms',
                'due_date',
                'schedule_first_payment',
                'schedule_second_payment',
                'schedule_third_payment',
                'schedule_fourth_payment',
                'schedule_fifth_payment',
                'schedule_sixth_payment',
                'schedule_seventh_payment',
                'schedule_eight_payment',
                'for_billing',
                'over_under_payment',
                'initial_payment',
                'good_as_sales_date',
                'status',
                'ra_comments',
                'admin_assistant_remarks',
                'tracking_number',
                'policy_received_by',
            ],
            'commision_details' => [
                'insurance_detail_id',
                'provision_receipt',
                'gross_premium',
                'discount',
                'net_discounted',
                'amount_due_to_provider',
                'full_commission',
                'marketing_fund',
                'offsetting',
                'promo',
                'total_commission',
                'vat',
                'sales_credit',
                'sales_credit_percent',
                'comm_deduct',
            ],
            'insurance_commisioners' => [
                'insurance_detail_id',
                'commisioner_id',
                'amount',
            ],
            'collection_details' => [
                'insurance_detail_id',
                'insurance_type',
                'sale_status',
                'tele_id',
                'due_date',
                'paid_terms',
                'payment_remarks',
                'account_status',
                'payment_ptp_declared',
                'payment_center',
                'reference_number',
                'date_on_receipt_abstract',
                'contact_number_verification',
            ],
        ];

        // Get the logged-in user's role
        $user = Auth::user();
        $role = $user->role; // Assuming the role is available on the user model

        // Fetch permissions for the user's role with `can_view` set to 1
        $permissions = RolePermission::where('role_id', $role->id)
            ->where('can_view', 1)
            ->get();

        // Filter records for each table based on permissions
        $data = [];
        foreach ($tables as $tableName => $columns) {
            // Fetch all records from the table
            $records = \DB::table($tableName);

            // Get the allowed columns from the permissions
            $allowedColumns = $permissions->where('table_name', $tableName)->pluck('column_name')->toArray();

            // If it's the insurance details table, join it with all related tables
            if ($tableName == 'insurance_details') {
                $records = $records
                    ->join('assureds', 'insurance_details.assured_id', '=', 'assureds.id')
                    ->join('sales_associates', 'insurance_details.sales_associate_id', '=', 'sales_associates.id')
                    ->join('branch_managers', 'insurance_details.branch_manager_id', '=', 'branch_managers.id')
                    ->join('products', 'insurance_details.product_id', '=', 'products.id')
                    ->join('subproducts', 'insurance_details.subproduct_id', '=', 'subproducts.id')
                    ->join('sources', 'insurance_details.source_id', '=', 'sources.id')
                    ->join('source_branches', 'insurance_details.source_branch_id', '=', 'source_branches.id')
                    ->join('if_gdfis', 'insurance_details.if_gdfi_id', '=', 'if_gdfis.id')
                    ->join('areas', 'insurance_details.area_id', '=', 'areas.id')
                    ->join('alfc_branches', 'insurance_details.alfc_branch_id', '=', 'alfc_branches.id')
                    ->join('mode_of_payments', 'insurance_details.mode_of_payment_id', '=', 'mode_of_payments.id')
                    ->join('providers', 'insurance_details.provider_id', '=', 'providers.id')
                    ->leftJoin('insurance_commisioners', 'insurance_details.id', '=', 'insurance_commisioners.insurance_detail_id')
                    ->leftJoin('commision_details', 'insurance_details.id', '=', 'commision_details.insurance_detail_id')
                    ->select(
                        'insurance_details.*',
                        'assureds.*',
                        'sales_associates.*',
                        'branch_managers.*',
                        'products.*',
                        'subproducts.*',
                        'sources.*',
                        'source_branches.*',
                        'if_gdfis.*',
                        'areas.*',
                        'alfc_branches.*',
                        'mode_of_payments.*',
                        'providers.*',
                        'insurance_commisioners.*',
                        'commision_details.*'
                    );
            }

            // Filter records to include only the permitted columns
            $filteredRecords = $records->get()->map(function ($record) use ($allowedColumns) {
                return (object) collect($record)->only($allowedColumns)->toArray(); // Return as object
            });

            // Assign the filtered records to the data array
            $data[$tableName] = $filteredRecords;
        }
        // Optionally, you can sort the results by a field, e.g., insurance details ID
        if (isset($data['insurance_details'])) {
            $data['insurance_details'] = $data['insurance_details']->sortBy('insurance_details.id');
        }

        return view('universal_table', compact('data', 'permissions'));
    }

    public function showRecords()
    {
        $user = Auth::user();
        $role = $user->role; // Assuming the role is available on the user model

        // Fetch permissions for the user's role with `can_view` set to 1
        $permissions = RolePermission::where('role_id', $role->id)
            ->where('can_view', 1)
            ->get();

        // Filter records for each table based on permissions
        $data = [];
        $tables = [
            'insurance_details',
            'assureds',
            'assured_details',
            'sales_associates',
            'branch_managers',
            'products',
            'subproducts',
            'sources',
            'source_branches',
            'if_gdfis',
            'areas',
            'alfc_branches',
            'mode_of_payments',
            'providers',
            'insurance_commisioners',
            'commision_details',
            'payment_details',
            'collection_details',  // Added collection_details table
        ];

        // Loop over each table
        foreach ($tables as $tableName) {
            // Fetch the allowed columns for this table
            $allowedColumns = $permissions->where('table_name', $tableName)
                ->pluck('column_name')
                ->toArray();

            // If there are allowed columns, build the query for this table
            if (count($allowedColumns) > 0) {
                $records = DB::table($tableName);

                // For 'insurance_details' table, join related tables
                if ($tableName == 'insurance_details') {
                    // Original code
                    $records = DB::table('insurance_details')
                        ->distinct() // Ensure no duplicates
                        ->leftJoin('assureds', 'insurance_details.assured_id', '=', 'assureds.id')
                        ->leftJoin('assured_details', 'assureds.assured_detail_id', '=', 'assured_details.id')
                        ->leftJoin('sales_associates', 'insurance_details.sales_associate_id', '=', 'sales_associates.id')
                        ->leftJoin('branch_managers', 'insurance_details.branch_manager_id', '=', 'branch_managers.id')
                        ->leftJoin('products', 'insurance_details.product_id', '=', 'products.id')
                        ->leftJoin('subproducts', 'insurance_details.subproduct_id', '=', 'subproducts.id')
                        ->leftJoin('sources', 'insurance_details.source_id', '=', 'sources.id')
                        ->leftJoin('source_branches', 'insurance_details.source_branch_id', '=', 'source_branches.id')
                        ->leftJoin('if_gdfis', 'insurance_details.if_gdfi_id', '=', 'if_gdfis.id')
                        ->leftJoin('areas', 'insurance_details.area_id', '=', 'areas.id')
                        ->leftJoin('alfc_branches', 'insurance_details.alfc_branch_id', '=', 'alfc_branches.id')
                        ->leftJoin('mode_of_payments', 'insurance_details.mode_of_payment_id', '=', 'mode_of_payments.id')
                        ->leftJoin('providers', 'insurance_details.provider_id', '=', 'providers.id')
                        ->leftJoin('insurance_commisioners', 'insurance_details.id', '=', 'insurance_commisioners.insurance_detail_id')
                        ->leftJoin('commision_details', 'insurance_details.id', '=', 'commision_details.insurance_detail_id')
                        ->leftJoin('payment_details', 'insurance_details.id', '=', 'payment_details.insurance_detail_id')
                        ->leftJoin('collection_details', 'insurance_details.id', '=', 'collection_details.insurance_detail_id'); // Join with collection_details table

                }

                // Add table name prefix to each column to avoid ambiguity
                $columnsWithPrefix = array_map(function ($column) use ($tableName) {
                    return "{$tableName}.{$column}";
                }, $allowedColumns);

                // Apply select to retrieve only allowed columns with prefixed table names
                $records = $records->select($columnsWithPrefix);

                // Fetch the records
                $data[$tableName] = $records->get();
            }
        }

        // Return the view with the data
        return view('universal_table', compact('data', 'permissions'));
    }



}
