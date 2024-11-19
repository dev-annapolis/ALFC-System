<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\RolePermission;

class RolePermissionController extends Controller
{
    public function edit()
    {
        $roles = Role::all();

        // Example table structure
        $tables = [
            'assured_details' => [
                'name',
                'address',
                'contact_number',
                'email',
                'other_contact_number',
                'facebook_account',
                'viber_account',
                'nature_of_business',
                'other_assets',
                'other_source_of_business'
            ],
            'insurance_details' => [
                'assured_detail_id',
                'issuance_code',
                'sale_date',
                'classification',
                'insurance_status',
                'team_id',
                'sales_associate_name',
                'sales_associate_id',
                'sales_manager_id',
                'book_number',
                'filing_number',
                'database_remarks',
                'pid_received_date',
                'pid_completion_date',
                'pid_status',
                'provider_id',
                'product_id',
                'subproduct_id',
                'product_type',
                'source_id',
                'source_branch_id',
                'if_gdfi_id',
                'mortgagee',
                'area_id',
                'alfc_branch_id',
                'policy_number',
                'plate_conduction_number',
                'description',
                'policy_inception_date',
                'expiry_date',
                'mode_of_payment_id',
                'loan_amount',
                'total_sum_insured',
                'policy_expiration_aging'
            ],
            'commission_details' => [
                'insurance_detail_id',
                'gross_premium',
                'discount',
                'gross_premium_net_discounted',
                'amount_due_to_provider',
                'full_commission',
                'travel_incentives',
                'offsetting',
                'promo',
                'vat',
                'sales_credit',
                'sales_credit_percent',
                'comm_deduct',
                'total_commission'
            ],
            'insurance_commissioners' => [
                'insurance_detail_id',
                'commissioner_id',
                'commissioner_name',
                'amount',
            ],
            'payment_details' => [
                'insurance_detail_id',
                'payment_terms',
                'due_date_start',
                'due_date_end',
                'first_payment_schedule',
                'first_payment_amount',
                'second_payment_schedule',
                'second_payment_amount',
                'third_payment_schedule',
                'third_payment_amount',
                'fourth_payment_schedule',
                'fourth_payment_amount',
                'fifth_payment_schedule',
                'fifth_payment_amount',
                'sixth_payment_schedule',
                'sixth_payment_amount',
                'seventh_payment_schedule',
                'seventh_payment_amount',
                'eight_payment_schedule',
                'eight_payment_amount',
                'provision_receipt',
                'initial_payment',
                'for_billing',
                'over_under_payment',
                'date_of_good_as_sales',
                'payment_status'
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
                'contact_number_verification'
            ]
        ];



        return view('permissions.edit', compact('roles', 'tables'));
    }

    public function update(Request $request)
    {
        $roles = Role::all();
        $tables = [
            'assured_details' => [
                'name',
                'address',
                'contact_number',
                'email',
                'other_contact_number',
                'facebook_account',
                'viber_account',
                'nature_of_business',
                'other_assets',
                'other_source_of_business'
            ],
            'insurance_details' => [
                'assured_detail_id',
                'issuance_code',
                'sale_date',
                'classification',
                'insurance_status',
                'team_id',
                'sales_associate_name',
                'sales_associate_id',
                'sales_manager_id',
                'book_number',
                'filing_number',
                'database_remarks',
                'pid_received_date',
                'pid_completion_date',
                'pid_status',
                'provider_id',
                'product_id',
                'subproduct_id',
                'product_type',
                'source_id',
                'source_branch_id',
                'if_gdfi_id',
                'mortgagee',
                'area_id',
                'alfc_branch_id',
                'policy_number',
                'plate_conduction_number',
                'description',
                'policy_inception_date',
                'expiry_date',
                'mode_of_payment_id',
                'loan_amount',
                'total_sum_insured',
                'policy_expiration_aging'
            ],
            'commission_details' => [
                'insurance_detail_id',
                'gross_premium',
                'discount',
                'gross_premium_net_discounted',
                'amount_due_to_provider',
                'full_commission',
                'travel_incentives',
                'offsetting',
                'promo',
                'vat',
                'sales_credit',
                'sales_credit_percent',
                'comm_deduct',
                'total_commission'
            ],
            'insurance_commissioners' => [
                'insurance_detail_id',
                'commissioner_id',
                'commissioner_name',
                'amount',
            ],
            'payment_details' => [
                'insurance_detail_id',
                'payment_terms',
                'due_date_start',
                'due_date_end',
                'first_payment_schedule',
                'first_payment_amount',
                'second_payment_schedule',
                'second_payment_amount',
                'third_payment_schedule',
                'third_payment_amount',
                'fourth_payment_schedule',
                'fourth_payment_amount',
                'fifth_payment_schedule',
                'fifth_payment_amount',
                'sixth_payment_schedule',
                'sixth_payment_amount',
                'seventh_payment_schedule',
                'seventh_payment_amount',
                'eight_payment_schedule',
                'eight_payment_amount',
                'provision_receipt',
                'initial_payment',
                'for_billing',
                'over_under_payment',
                'date_of_good_as_sales',
                'payment_status'
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
                'contact_number_verification'
            ]
        ];


        foreach ($roles as $role) {
            foreach ($tables as $table => $columns) {
                foreach ($columns as $column) {
                    // Check if 'view' and 'edit' permissions exist for this role, table, and column
                    $canView = isset($request->permissions[$role->id][$table][$column]['view']);
                    $canEdit = isset($request->permissions[$role->id][$table][$column]['edit']);

                    // Update or create the permission record
                    RolePermission::updateOrCreate(
                        [
                            'role_id' => $role->id,
                            'table_name' => $table,
                            'column_name' => $column
                        ],
                        [
                            'can_view' => $canView,
                            'can_edit' => $canEdit,
                        ]
                    );
                }
            }
        }

        return redirect()->route('permissions.edit')->with('success', 'Permissions updated successfully.');
    }


}
