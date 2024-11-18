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
                'assured_name',
                'address',
                'contact_number',
                'other_contact_number',
                'email',
                'facebook_account',
                'viber_account',
                'nature_of_business',
                'other_assets',
                'remarks',
            ],
            'insurance_details' => [
                'issuance_code',
                'assured_name',
                'sales_associate_name',
                'sale_date',
                'classification',
                'insurance_type',
                'sale_status',
                'branch_manager_name',
                'legal_representative_name',
                'legal_supervisor_name',
                'assigned_atty_one',
                'assigned_atty_two',
                'collection_gm',
                'product_name',
                'subproduct_name',
                'source_name',
                'source_branch_name',
                'if_gdfi_name',
                'mortgagee',
                'area_name',
                'alfc_branch_name',
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
                'mode_of_payment_name',
                'provider_name',
            ],
            'commission_details' => [
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
            'insurance_commissioners' => [
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
                'due_date',
                'schedule_first_payment',
                'schedule_second_payment',
                'schedule_third_payment',
                'schedule_fourth_payment',
                'schedule_fifth_payment',
                'schedule_sixth_payment',
                'schedule_seventh_payment',
                'schedule_eighth_payment',
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
        ];



        return view('permissions.edit', compact('roles', 'tables'));
    }

    public function update(Request $request)
    {
        $roles = Role::all();
        $tables = [
            'assured_details' => [
                'assured_name',
                'address',
                'contact_number',
                'other_contact_number',
                'email',
                'facebook_account',
                'viber_account',
                'nature_of_business',
                'other_assets',
                'remarks',
            ],
            'insurance_details' => [
                'issuance_code',
                'assured_name',
                'sales_associate_name',
                'sale_date',
                'classification',
                'insurance_type',
                'sale_status',
                'branch_manager_name',
                'legal_representative_name',
                'legal_supervisor_name',
                'assigned_atty_one',
                'assigned_atty_two',
                'collection_gm',
                'product_name',
                'subproduct_name',
                'source_name',
                'source_branch_name',
                'if_gdfi_name',
                'mortgagee',
                'area_name',
                'alfc_branch_name',
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
                'mode_of_payment_name',
                'provider_name',
            ],
            'commission_details' => [
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
            'insurance_commissioners' => [
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
                'due_date',
                'schedule_first_payment',
                'schedule_second_payment',
                'schedule_third_payment',
                'schedule_fourth_payment',
                'schedule_fifth_payment',
                'schedule_sixth_payment',
                'schedule_seventh_payment',
                'schedule_eighth_payment',
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
