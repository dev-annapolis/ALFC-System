<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\AssuredDetail;
use App\Models\Team;
use App\Models\User;
use App\Models\SalesAssociate;
use App\Models\InsuranceDetail;
use App\Models\Product;
use App\Models\Subproduct;
use App\Models\Source;
use App\Models\SourceBranch;
use App\Models\SourceDivision;
use App\Models\Area;
use App\Models\AlfcBranch;
use App\Models\ModeOfPayment;
use App\Models\Provider;

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
            'SALES ASSOCIATE' => [] ];

        foreach ($collection as $index => $row) {
            if (empty($row['issuance_code'])) $missingFields['ISSUANCE CODE'][] = $index + 2;
            if (empty($row['assured_name'])) $missingFields['ASSURED NAME'][] = $index + 2;
            if (empty($row['team'])) $missingFields['TEAM'][] = $index + 2;
            if (empty($row['sales_associate'])) $missingFields['SALES ASSOCIATE'][] = $index + 2;}

        // COLLECT MISSING FIELDS
        foreach ($missingFields as $field => $missingRows) {
            if (count($missingRows) > 0) {
                $error = true;
                $errorMessage .= "Missing $field at rows: " . implode(', ', $missingRows) . "\n \n"; }}

        // THROW ERROR IF MISSING FIELDS
        if ($error) {
            $errorMessage = str_replace("\n", '<br>', $errorMessage);
            throw new \Exception($errorMessage); }

        // TRANSACTION BEGIN
        DB::beginTransaction();
        try {
            foreach ($collection as $index => $row) {
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

                $teamId = !empty($row['team']) ? Team::firstOrCreate(['name' => $row['team']])->id : null;
                $productId = !empty($row['product']) ? Product::firstOrCreate(['name' => $row['product']])->id : null;
                $subproductId = !empty($row['subproduct']) ? Subproduct::firstOrCreate(['name' => $row['subproduct']])->id : null;
                $sourceId = !empty($row['source']) ? Source::firstOrCreate(['name' => $row['source']])->id : null;
                $sourceBranchId = !empty($row['affi_branch']) ? SourceBranch::firstOrCreate(['name' => $row['affi_branch']])->id : null;
                $sourceDivisionId = !empty($row['division']) ? SourceDivision::firstOrCreate(['name' => $row['division']])->id : null;
                $areaId = !empty($row['area']) ? SourceDivision::firstOrCreate(['name' => $row['area']])->id : null;
                $alfcBranchId = !empty($row['alfc_branch']) ? SourceDivision::firstOrCreate(['name' => $row['alfc_branch']])->id : null;
                $modeOfPaymentId = !empty($row['mode_of_payment']) ? ModeOfPayment::firstOrCreate(['name' => $row['mode_of_payment']])->id : null;
                $providerId = !empty($row['provider']) ? Provider::firstOrCreate(['name' => $row['provider']])->id : null;


                $salesAssociateId = !empty($row['sales_associate']) ? SalesAssociate::firstOrCreate(
                    ['name' => $row['sales_associate']],
                    [
                        'user_id' => User::firstOrCreate([
                            'name' => $row['sales_associate'],
                            'username' => strtolower(str_replace(' ', '', $row['sales_associate'])),
                            'password' => Hash::make(strtolower(str_replace(' ', '', $row['sales_associate']))),
                            'role_id' => 8,
                        ])->id,
                        'team_id' => $teamId
                    ]
                )->id : null;

                $regionalManagerId = !empty($row['regional_manager']) ? RegionalManager::firstOrCreate(
                    ['name' => $row['regional_manager']],
                    [
                        'user_id' => User::firstOrCreate([
                            'name' => $row['regional_manager'],
                            'username' => strtolower(str_replace(' ', '', $row['regional_manager'])),
                            'password' => Hash::make(strtolower(str_replace(' ', '', $row['regional_manager']))),
                            'role_id' => 10,
                        ])->id,
                        'team_id' => $teamId
                    ]
                )->id : null;

                $saleDate = !empty($row['sale_date']) ? Carbon::createFromFormat('F j, Y', $row['sale_date'])->format('Y-m-d') : null;
                $policyInceptionDate = !empty($row['policy_inception_date']) ? Carbon::createFromFormat('F j, Y', $row['policy_inception_date'])->format('Y-m-d') : null;
                $expiryDate = !empty($row['expiry_date']) ? Carbon::createFromFormat('F j, Y', $row['expiry_date'])->format('Y-m-d') : null;
                
                // Create InsuranceDetail
                $InsuranceDetail = InsuranceDetail::create([
                    'assured_detail_id' => $AssuredDetailId,
                    'issuance_code' => $row['issuance_code'] ?? null,
                    'team_id' => $teamId,
                    'sales_associate_id' => $salesAssociateId,
                    'regional_manager_id' => $regionalManagerId,
                    'sale_date' => $saleDate,
                    'classification' => $row['classification'] ?? null,
                    'insurance_status' => $row['insurance_status'] ?? null,
                    'product_id' => $productId,
                    'subproduct_id' => $subproductId,
                    'source_id' => $sourceId ,
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
                    'mode_of_payment_id' => $row['mode_of_payment'] ?? null,
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
                $InsuranceDetail = PaymentDetail::create([
                    'insurance_detail_id' => $InsuranceDetail->id,
                    
                    'provision_receipt' => $row['provision_receipt'] ?? null,
                    'provider_id' => $providerId,

                    // provision_receipt
                    // provider
                    // gross_premium
                    // discount
                    // gross_premium_net_of_discounts
                    // amount_due_to_provider
                    // full_commission
                    // total_commission
                    // vat
                    // sales_credit
                    // salestcredit_percent
                    // comm_deduct
                    // payment_terms
                    // due_date_term
                    // schedule_of_first_payment
                    // schedule_of_second_payment
                    // schedule_of_third_payment
                    // schedule_of_fourth_payment
                    // schedule_of_fifth_payment
                    // schedule_of_sixth_payment
                    // schedule_of_seventh_payment
                    // schedule_of_eight_payment
                    // for_billing
                    // over_under_payment
                    // initial_payment
                    // date_of_good_as_sales
                    // status

                ]);
            }
            DB::commit(); // COMMIT UPLOADED DATA IF NO ERRORS
        } catch (\Exception $e) {
            DB::rollBack(); // ROLLBACK IF THERE'S AN ERROR
            throw $e; // Rethrow the exception to be handled elsewhere
        }
    }

    public function headingRow(): int
    {
        return 1; // SET ROW 1 AS HEADING ROW
    }
}



                        