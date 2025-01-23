<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\AssuredDetail;
use App\Models\InsuranceDetail;
use App\Models\PaymentDetail;
use App\Models\InsuranceCommissioner;

use App\Models\User;
use App\Models\SalesAssociate;
use App\Models\RegionalManager;

use App\Models\Team;
use App\Models\Product;
use App\Models\Subproduct;
use App\Models\Source;
use App\Models\SourceBranch;
use App\Models\SourceDivision;
use App\Models\Area;
use App\Models\AlfcBranch;
use App\Models\ModeOfPayment;
use App\Models\Provider;
use App\Models\ArAging;
use App\Models\ArAgingPivot;

use Log;
use Carbon\Carbon;

class DataImport implements ToCollection, WithHeadingRow 
{
    use Importable;

    public function collection(Collection $collection)
    {
        // DECLARE VARIABLES
        $error = false;
        $errorMessage = '';
        $missingFields = [
            'ISSUANCE CODE' => [],
            'ASSURED NAME' => [],
            'TEAM' => [],
            'SALES ASSOCIATE' => [],
            'GROSS PREMIUM' => [],
            'GROSS PREMIUM NET OF DISCOUNTS' => [], ];
        $current_index = 0;

        Log::info('Upload Started');

        foreach ($collection as $index => $row) {
            if (empty($row['issuance_code'])) $missingFields['ISSUANCE CODE'][] = $index + 2;
            if (empty($row['assured_name'])) $missingFields['ASSURED NAME'][] = $index + 2;
            if (empty($row['team'])) $missingFields['TEAM'][] = $index + 2;
            if (empty($row['sales_associate'])) $missingFields['SALES ASSOCIATE'][] = $index + 2;
            if (empty($row['gross_premium'])) $missingFields['GROSS PREMIUM'][] = $index + 2;
            if (empty($row['gross_premium_net_of_discounts'])) $missingFields['GROSS PREMIUM NET OF DISCOUNTS'][] = $index + 2;}
            
            
        // COLLECT MISSING FIELDS
        foreach ($missingFields as $field => $missingRows) {
            if (count($missingRows) > 0) {
                Log::info('Blank Data Found');
                $error = true;
                $errorMessage .= "Missing $field at rows: " . implode(', ', $missingRows) . "\n \n"; }}

        // THROW ERROR IF MISSING FIELDS
        if ($error) {
            $errorMessage = str_replace("\n", '<br>', $errorMessage);
            throw new \Exception($errorMessage); }

        // TRANSACTION BEGIN
        DB::beginTransaction();
        try {
            Log::info('No Errors Found');
            foreach ($collection as $index => $row) {
                $current_index = $index + 2;
                // AssuredDetail logic
                $existingAssuredDetail = AssuredDetail::where('name', $row['assured_name'])->first();
                $AssuredDetailId = $existingAssuredDetail ? $existingAssuredDetail->id : AssuredDetail::create([
                    'name' => $row['assured_name'],
                    'lot_number' => $row['address'] ?? null,
                    'contact_number' => $row['contact_no'] ?? null,
                    'facebook_account' => $row['facebook_account'] ?? null,
                    'viber_account' => $row['viber_account'] ?? null,
                    'primary_reference' => $row['primary_reference'] ?? null,
                    'verified_number' => $row['verified_number'] ?? null,
                    'verified_mailing_address' => $row['verified_mailing_address'] ?? null,
                    'customer_care_remarks' => $row['customer_care_remarks'] ?? null,
                ])->id;

                // generate ID from tables
                $teamId = !empty($row['team']) ? Team::firstOrCreate(['name' => $row['team']])->id : null;
                $productId = !empty($row['product']) ? Product::firstOrCreate(['name' => $row['product']])->id : null;
                $subproductId = !empty($row['subproduct']) ? Subproduct::firstOrCreate(['name' => $row['subproduct']])->id : null;
                $sourceId = !empty($row['source']) ? Source::firstOrCreate(['name' => $row['source']])->id : null;
                $sourceBranchId = !empty($row['affi_branch']) ? SourceBranch::firstOrCreate(['name' => $row['affi_branch']])->id : null;
                $sourceDivisionId = !empty($row['division']) ? SourceDivision::firstOrCreate(['name' => $row['division']])->id : null;
                $areaId = !empty($row['area']) ? Area::firstOrCreate(['name' => $row['area']])->id : null;
                $alfcBranchId = !empty($row['alfc_branch']) ? AlfcBranch::firstOrCreate(['name' => $row['alfc_branch']])->id : null;
                $modeOfPaymentId = !empty($row['mode_of_payment']) ? ModeOfPayment::firstOrCreate(['name' => $row['mode_of_payment']])->id : null;
                $providerId = !empty($row['provider']) ? Provider::firstOrCreate(['name' => $row['provider']])->id : null;

                // Handle Sales Associate
                if (!empty($row['sales_associate'])) {
                    // Retrieve or create the User for the sales associate
                    $user = User::firstOrCreate(
                        ['username' => strtolower(str_replace(' ', '', $row['sales_associate']))],
                        [
                            'name' => $row['sales_associate'],
                            'password' => Hash::make(strtolower(str_replace(' ', '', $row['sales_associate']))),
                            'role_id' => 8,
                        ]
                    );

                    // Retrieve or create the Sales Associate
                    $salesAssociateId = SalesAssociate::firstOrCreate(
                        ['name' => $row['sales_associate']],
                        [
                            'user_id' => $user->id,
                            'team_id' => $teamId
                        ]
                    )->id;
                } else {
                    $salesAssociateId = null;
                }

                // Handle Regional Manager
                if (!empty($row['regional_manager'])) {
                    // Retrieve or create the User for the regional manager
                    $user = User::firstOrCreate(
                        ['username' => strtolower(str_replace(' ', '', $row['regional_manager']))],
                        [
                            'name' => $row['regional_manager'],
                            'password' => Hash::make(strtolower(str_replace(' ', '', $row['regional_manager']))),
                            'role_id' => 10,
                        ]
                    );

                    // Retrieve or create the Regional Manager
                    $regionalManagerId = RegionalManager::firstOrCreate(
                        ['name' => $row['regional_manager']],
                        [
                            'user_id' => $user->id,
                            'team_id' => $teamId
                        ]
                    )->id;
                } else {
                    $regionalManagerId = null;
                }


                $saleDate = !empty($row['sale_date']) ? Carbon::createFromFormat('F j, Y', $row['sale_date'])->format('Y-m-d') : null;
                $policyInceptionDate = !empty($row['policy_inception_date']) ? Carbon::createFromFormat('F j, Y', $row['policy_inception_date'])->format('Y-m-d') : null;
                $expiryDate = !empty($row['expiry_date']) ? Carbon::createFromFormat('F j, Y', $row['expiry_date'])->format('Y-m-d') : null;
                $goodAsSalesDate = !empty($row['date_of_good_as_sales']) ? Carbon::createFromFormat('F j, Y', $row['date_of_good_as_sales'])->format('Y-m-d') : null;
                
                $dueDateTerm = $row['due_date_term'] ?? null;
                if ($dueDateTerm === "FOR BILLING") {
                    $dueDateStart = "FOR BILLING";
                    $dueDateEnd = "FOR BILLING";
                } elseif (!empty($dueDateTerm) && preg_match('/\b(\w+ \d{1,2}, \d{4}) - (\w+ \d{1,2}, \d{4})\b/', $dueDateTerm, $matches)) {
                    // Case with two dates
                    $dueDateStart = Carbon::createFromFormat('F j, Y', $matches[1])->format('Y-m-d');
                    $dueDateEnd = Carbon::createFromFormat('F j, Y', $matches[2])->format('Y-m-d');
                } elseif (!empty($dueDateTerm) && preg_match('/\b(\w+ \d{1,2}, \d{4})\b/', $dueDateTerm, $matches)) {
                    // Case with only one date
                    $dueDateStart = Carbon::createFromFormat('F j, Y', $matches[1])->format('Y-m-d');
                    $dueDateEnd = $dueDateStart; // Set both start and end as the same date
                } else {
                    $dueDateStart = null;
                    $dueDateEnd = null;
                }
                
                // Create InsuranceDetail
                $InsuranceDetail = InsuranceDetail::create([
                    'assured_detail_id' => $AssuredDetailId,
                    'issuance_code' => $row['issuance_code'],
                    'team_id' => $teamId,
                    'sales_associate_id' => $salesAssociateId,
                    'regional_manager_id' => $regionalManagerId,
                    'sale_date' => $saleDate,
                    'classification' => $row['classification'] ?? null,
                    'insurance_status' => $row['insurance_status'] ?? null,
                    'product_id' => $productId,
                    'subproduct_id' => $subproductId,
                    'source_id' => $sourceId,
                    'source_branch_id' => $sourceBranchId,
                    'source_division_id' => $sourceDivisionId,
                    'mortgagee' => $row['mortgagee'] ?? null,
                    'area_id' => $areaId,
                    'alfc_branch_id' => $alfcBranchId,
                    'loan_amount' => $row['loan_amount'] ?? null,
                    'total_sum_insured' => $row['total_sum_insured'] ?? null,
                    'policy_inception_date' => $policyInceptionDate,
                    'expiry_date' => $expiryDate,
                    'policy_number' => $row['policy_no'] ?? null,
                    'plate_conduction_number' => $row['plate_conduction_no'] ?? null,
                    'description' => $row['description'] ?? null,
                    'mode_of_payment_id' => $modeOfPaymentId,
                    'ra_comments' => $row['ra_comments'] ?? null,
                    'admin_assistant_remarks' => $row['admin_asst_remarks'] ?? null,
                    'tracking_number' => $row['tracking_number'] ?? null,
                    'mode_of_delivery' => $row['mode_of_delivery'] ?? null,
                    'policy_received_by' => $row['policy_received_by'] ?? null,
                    'policy_expiration_aging' => $row['policy_expiration_aging_days'] ?? null,
                    'book_number' => $row['book_no'] ?? null,
                    'filing_number' => $row['filing_no'] ?? null,
                    'database_remarks' => $row['remarks'] ?? null,
                    'pid_received_date' => $row['pid_received_date'] ?? null,
                    'pid_status' => $row['pid_status'] ?? null,
                    'pid_completion_date' => $row['pid_completion_date'] ?? null,
                ]);

                // Create PaymentDetail
                $PaymentDetail = PaymentDetail::create([
                    'insurance_detail_id' => $InsuranceDetail->id,
                    'provision_receipt' => $row['provision_receipt'] ?? null,
                    'provider_id' => $providerId,
                    'gross_premium' => $row['gross_premium'] ?? null,
                    'discount' => $row['discount'] ?? null,
                    'gross_premium_net_discounted' => $row['gross_premium_net_of_discounts'] ?? null,
                    'amount_due_to_provider' => $row['amount_due_to_provider'] ?? null,
                    'full_commission' => $row['full_commission'] ?? null,
                    'total_commission' => $row['total_commission'] ?? null,
                    'vat' => $row['vat'] ?? null,
                    'sales_credit' => $row['sales_credit'] ?? null,
                    'sales_credit_percent' => $row['sales_credit_percent'] ?? null,
                    'comm_deduct' => $row['comm_deduct'] ?? null,
                    'payment_terms' => $row['payment_terms'] ?? 0,
                    'due_date_start' => $dueDateStart,
                    'due_date_end' => $dueDateEnd,
                    'first_payment_schedule' => null,
                    'first_payment_amount' => $row['schedule_of_first_payment'] ?? null,
                    'second_payment_schedule' => null,
                    'second_payment_amount' => $row['schedule_of_second_payment'] ?? null,
                    'third_payment_schedule' => null,
                    'third_payment_amount' => $row['schedule_of_third_payment'] ?? null,
                    'fourth_payment_schedule' => null,
                    'fourth_payment_amount' => $row['schedule_of_fourth_payment'] ?? null,
                    'fifth_payment_schedule' => null,
                    'fifth_payment_amount' => $row['schedule_of_fifth_payment'] ?? null,
                    'sixth_payment_schedule' => null,
                    'sixth_payment_amount' => $row['schedule_of_sixth_payment'] ?? null,
                    'seventh_payment_schedule' => null,
                    'seventh_payment_amount' => $row['schedule_of_seventh_payment'] ?? null,
                    'eight_payment_schedule' => null,
                    'eight_payment_amount' => $row['schedule_of_eight_payment'] ?? null,
                    'for_billing' => $row['for_billing'] ?? null,
                    'over_under_payment' => $row['over_under_payment'] ?? null,
                    'initial_payment' => $row['initial_payment'] ?? null,
                    'date_of_good_as_sales' => $goodAsSalesDate,
                    'payment_status' => $row['status'] ?? null,
                ]);

                if (!empty($row['marketing_arm']) && $row['marketing_arm'] !== 'N/A') {
                    InsuranceCommissioner::create([
                        'insurance_detail_id' => $InsuranceDetail->id,
                        'commissioner_id' => 1,
                        'commissioner_name' => $row['marketing_arm'],
                        'amount' => 0,
                    ]);
                }

                if (!empty($row['referred_by']) && $row['referred_by'] !== 'N/A') {
                    InsuranceCommissioner::create([
                        'insurance_detail_id' => $InsuranceDetail->id,
                        'commissioner_id' => 2,
                        'commissioner_name' => $row['referred_by'],
                        'amount' => 0,
                    ]);
                }

                if (!empty($row['legal_representative_name']) && $row['legal_representative_name'] !== 'N/A') {
                    InsuranceCommissioner::create([
                        'insurance_detail_id' => $InsuranceDetail->id,
                        'commissioner_id' => 3,
                        'commissioner_name' => $row['legal_representative_name'],
                        'amount' => 0,
                    ]);
                }

                if (!empty($row['legal_supervisor_name']) && $row['legal_supervisor_name'] !== 'N/A') {
                    InsuranceCommissioner::create([
                        'insurance_detail_id' => $InsuranceDetail->id,
                        'commissioner_id' => 4,
                        'commissioner_name' => $row['legal_supervisor_name'],
                        'amount' => 0,
                    ]);
                }

                if (!empty($row['assigned_atty_one']) && $row['assigned_atty_one'] !== 'N/A') {
                    InsuranceCommissioner::create([
                        'insurance_detail_id' => $InsuranceDetail->id,
                        'commissioner_id' => 5,
                        'commissioner_name' => $row['assigned_atty_one'],
                        'amount' => empty($row['assigned_atty_one_amount']) ?? 0,
                    ]);
                } else {
                    if (!empty($row['assigned_atty_one_amount'])) {
                        InsuranceCommissioner::create([
                            'insurance_detail_id' => $InsuranceDetail->id,
                            'commissioner_id' => 5,
                            'commissioner_name' => null,
                            'amount' => empty($row['assigned_atty_one_amount']),
                        ]);
                    }
                }

                if (!empty($row['assigned_atty_two']) && $row['assigned_atty_two'] !== 'N/A') {
                    InsuranceCommissioner::create([
                        'insurance_detail_id' => $InsuranceDetail->id,
                        'commissioner_id' => 6,
                        'commissioner_name' => $row['assigned_atty_two'],
                        'amount' => empty($row['assigned_atty_two_amount']) ?? 0,
                    ]);
                } else {
                    if (!empty($row['assigned_atty_two_amount'])) {
                        InsuranceCommissioner::create([
                            'insurance_detail_id' => $InsuranceDetail->id,
                            'commissioner_id' => 6,
                            'commissioner_name' => null,
                            'amount' => empty($row['assigned_atty_two_amount']),
                        ]);
                    }
                }

                if (!empty($row['collection_gm']) && $row['collection_gm'] !== 'N/A') {
                    InsuranceCommissioner::create([
                        'insurance_detail_id' => $InsuranceDetail->id,
                        'commissioner_id' => 7,
                        'commissioner_name' => $row['collection_gm'],
                        'amount' => empty($row['collection_gm_amount']) ?? 0,
                    ]);
                } else {
                    if (!empty($row['collection_gm_amount'])) {
                        InsuranceCommissioner::create([
                            'insurance_detail_id' => $InsuranceDetail->id,
                            'commissioner_id' => 7,
                            'commissioner_name' => null,
                            'amount' => empty($row['collection_gm_amount']),
                        ]);
                    }
                }
                
                $amountFields = [
                    8  => 'agent_dealer',
                    9  => 'bm_emp',
                    10 => 'pmm_adh',
                    11 => 'financing',
                    12 => 'marketing_head',
                    13 => 'am',
                    14 => 'gm_president',
                    15 => 'group_head',
                    16 => 'rm',
                    17 => 'afc_atl_gm',
                    18 => 'referral_fee_program',
                    19 => 'nip',
                    20 => 'individual_legal',
                    21 => 'additional_legal',
                    22 => 'marketing_fund',
                    23 => 'offsetting',
                    24 => 'promo',
                ];

                // Insert amount-based rows
                foreach ($amountFields as $id => $field) {
                    if (!empty($row[$field])) {
                        InsuranceCommissioner::create([
                            'insurance_detail_id' => $InsuranceDetail->id,
                            'commissioner_id' => $id,
                            'commissioner_name' => null,
                            'amount' => $row[$field],
                        ]);
                    }
                }

                // Declare Balance and set initial value to 0 if does not exists
                $initial = $row['initial_payment'] ?? 0;
                $balance = $row['gross_premium_net_of_discounts'] - $initial;

                // Create AR Aging
                $arAging = ArAging::create([
                    'insurance_detail_id' => $InsuranceDetail->id,
                    'issuance_code' => $row['issuance_code'],
                    'name' => $row['assured_name'],
                    'due_date_start' => $dueDateStart,
                    'due_date_end' => $dueDateEnd,
                    'terms' => $row['payment_terms'] ?? 0,
                    'team' => $teamId,
                    'policy_number' => $row['policy_no'] ?? 1,
                    'sale_date' => $saleDate,
                    'mode_of_payment' => $modeOfPaymentId,
                    'gross_premium' => $row['gross_premium_net_of_discounts'],
                    'total_outstanding' => $row['initial_payment'] ?? 0,
                    'balance' => $balance,
                ]);

                $terms = (int) $row['payment_terms'] ?? 0;
                $paymentSchedules = [
                    ['schedule' => $PaymentDetail->first_payment_schedule, 'amount' => $PaymentDetail->first_payment_amount],
                    ['schedule' => $PaymentDetail->second_payment_schedule, 'amount' => $PaymentDetail->second_payment_amount],
                    ['schedule' => $PaymentDetail->third_payment_schedule, 'amount' => $PaymentDetail->third_payment_amount],
                    ['schedule' => $PaymentDetail->fourth_payment_schedule, 'amount' => $PaymentDetail->fourth_payment_amount],
                    ['schedule' => $PaymentDetail->fifth_payment_schedule, 'amount' => $PaymentDetail->fifth_payment_amount],
                    ['schedule' => $PaymentDetail->sixth_payment_schedule, 'amount' => $PaymentDetail->sixth_payment_amount],
                    ['schedule' => $PaymentDetail->seventh_payment_schedule, 'amount' => $PaymentDetail->seventh_payment_amount],
                    ['schedule' => $PaymentDetail->eight_payment_schedule, 'amount' => $PaymentDetail->eight_payment_amount],
                ];
                for ($i = 0; $i < min($terms, 8); $i++) {
                    $label = $i === 0 ? 'current' : (($i - 1) * 30 + 1) . '-' . ($i * 30);
                    $schedule = $paymentSchedules[$i];

                    ArAgingPivot::create([
                        'ar_aging_id' => $arAging->id,
                        'label' => $label,
                        'payment_amount' => $schedule['amount'],
                        'payment_schedule' => $schedule['schedule'],
                        'paid_amount' => null, 
                        'paid_schedule' => null,
                        'over_under_payment' => null,
                        'reference_number' => null,
                        'ra_remarks' => null,
                        'tele_remarks' => null,
                        'paid' => 0, 
                    ]);
                }
                
            }
            Log::info('Upload Success');
            DB::commit(); // COMMIT UPLOADED DATA IF NO ERRORS
        } catch (\Exception $e) {
            DB::rollBack(); // ROLLBACK IF THERE'S AN ERROR
            Log::info('Error Found at row '. $current_index);
            $errorMessage = ' at line ' . $current_index; // Save the message to a variable
            throw new \Exception($e->getMessage() . $errorMessage); // Append the message and rethrow the exception
        }
    }

    public function headingRow(): int
    {
        return 1; // SET ROW 1 AS HEADING ROW
    }
}



                        