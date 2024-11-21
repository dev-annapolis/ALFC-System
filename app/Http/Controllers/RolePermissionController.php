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

        $tables = [
            'assured_details' => [
                'name',
                'lot_number',
                'street',
                'barangay',
                'city',
                'country',
                'contact_number',
                'other_contact_number',
                'email',
                'facebook_account',
                'viber_account',
                'nature_of_business',
                'other_assets',
                'other_source_of_business',
            ],
            'insurance_details' => [
                'name',
                'issuance_code',
                'team_name',
                'sale_date',
                'sales_associate_name',
                'sales_manager_name',
                'classification',
                'insurance_status',
                'book_number',
                'filing_number',
                'database_remarks',
                'pid_received_date',
                'pid_completion_date',
                'pid_status',
                'provider_name',
                'product_name',
                'subproduct_name',
                'product_type',
                'source_name',
                'source_branch_name',
                'if_gdfi',
                'mortgagee',
                'area_name',
                'alfc_branch_name',
                'policy_number',
                'plate_conduction_number',
                'description',
                'policy_inception_date',
                'expiry_date',
                'policy_expiration_aging',
                'loan_amount',
                'total_sum_insured',
                'mode_of_payment_name',
            ],
            'commission_details' => [
                'gross_premium',
                'discount',
                'gross_premium_net_discounted',
                'amount_due_to_provider',
                'full_commission',
                'travel_incentives',
                'offsetting',
                'promo',
                'total_commission',
                'vat',
                'sales_credit',
                'sales_credit_percent',
                'comm_deduct',
            ],
            'insurance_commissioners' => [
                'commissioner_title',
                'commissioner_name',
                'amount',
            ],
            'collection_details' => [
                'insurance_type',
                'sale_status',
                'tele_name',
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
            'payment_details' => [
                'payment_terms',
                'date_of_good_as_sales',
                'due_date_start',
                'due_date_end',
                'schedule_first_payment',
                'amount_first_payment',
                'schedule_second_payment',
                'amount_second_payment',
                'schedule_third_payment',
                'amount_third_payment',
                'schedule_fourth_payment',
                'amount_fourth_payment',
                'schedule_fifth_payment',
                'amount_fifth_payment',
                'schedule_sixth_payment',
                'amount_sixth_payment',
                'schedule_seventh_payment',
                'amount_seventh_payment',
                'schedule_eighth_payment',
                'amount_eighth_payment',
                'provision_receipt',
                'initial_payment',
                'for_billing',
                'over_under_payment',
                'payment_status',
            ],
        ];
        



        return view('permissions.edit', compact('roles', 'tables'));
    }

    public function update(Request $request)
    {
        $roles = Role::all();
        $tables = [
            'assured_details' => [
                'name',
                'lot_number',
                'street',
                'barangay',
                'city',
                'country',
                'contact_number',
                'other_contact_number',
                'email',
                'facebook_account',
                'viber_account',
                'nature_of_business',
                'other_assets',
                'other_source_of_business',
            ],
            'insurance_details' => [
                'name',
                'issuance_code',
                'team_name',
                'sale_date',
                'sales_associate_name',
                'sales_manager_name',
                'classification',
                'insurance_status',
                'book_number',
                'filing_number',
                'database_remarks',
                'pid_received_date',
                'pid_completion_date',
                'pid_status',
                'provider_name',
                'product_name',
                'subproduct_name',
                'product_type',
                'source_name',
                'source_branch_name',
                'if_gdfi',
                'mortgagee',
                'area_name',
                'alfc_branch_name',
                'policy_number',
                'plate_conduction_number',
                'description',
                'policy_inception_date',
                'expiry_date',
                'policy_expiration_aging',
                'loan_amount',
                'total_sum_insured',
                'mode_of_payment_name',
            ],
            'commission_details' => [
                'gross_premium',
                'discount',
                'gross_premium_net_discounted',
                'amount_due_to_provider',
                'full_commission',
                'travel_incentives',
                'offsetting',
                'promo',
                'total_commission',
                'vat',
                'sales_credit',
                'sales_credit_percent',
                'comm_deduct',
            ],
            'insurance_commissioners' => [
                'commissioner_title',
                'commissioner_name',
                'amount',
            ],
            'collection_details' => [
                'insurance_type',
                'sale_status',
                'tele_name',
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
            'payment_details' => [
                'payment_terms',
                'date_of_good_as_sales',
                'due_date_start',
                'due_date_end',
                'schedule_first_payment',
                'amount_first_payment',
                'schedule_second_payment',
                'amount_second_payment',
                'schedule_third_payment',
                'amount_third_payment',
                'schedule_fourth_payment',
                'amount_fourth_payment',
                'schedule_fifth_payment',
                'amount_fifth_payment',
                'schedule_sixth_payment',
                'amount_sixth_payment',
                'schedule_seventh_payment',
                'amount_seventh_payment',
                'schedule_eighth_payment',
                'amount_eighth_payment',
                'provision_receipt',
                'initial_payment',
                'for_billing',
                'over_under_payment',
                'payment_status',
            ],
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
