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

                $team = Team::firstOrCreate(['name' => $row['team']]);
                $product = Product::firstOrCreate(['name' => $row['product']]);
                $subproduct = Subproduct::firstOrCreate(['name' => $row['subproduct']]);

                $salesAssociate = SalesAssociate::firstOrCreate(
                    ['name' => $row['sales_associate']],
                    [
                        'user_id' => User::firstOrCreate([
                            'name' => $row['sales_associate'],
                            'username' => strtolower(str_replace(' ', '', $row['sales_associate'])),
                            'password' => Hash::make(strtolower(str_replace(' ', '', $row['sales_associate']))),
                            'role_id' => 8,
                        ])->id,
                        'team_id' => $team->id
                    ]
                );

                $regionalManager = RegionalManager::firstOrCreate(
                    ['name' => $row['regional_manager']],
                    [
                        'user_id' => User::firstOrCreate([
                            'name' => $row['regional_manager'],
                            'username' => strtolower(str_replace(' ', '', $row['regional_manager'])),
                            'password' => Hash::make(strtolower(str_replace(' ', '', $row['regional_manager']))),
                            'role_id' => 10,
                        ])->id,
                        'team_id' => $team->id
                    ]
                );

                $saleDate = $row['sale_date'] ? Carbon::createFromFormat('F j, Y', $row['sale_date'])->format('Y-m-d') : null;

                // Create InsuranceDetail
                $InsuranceDetail = InsuranceDetail::create([
                    'assured_detail_id' => $AssuredDetailId,
                    'issuance_code' => $row['issuance_code'],
                    'team_id' => $team->id,
                    'sales_associate_id' => $salesAssociate->id,
                    'regional_manager_id' => $regionalManager->id,
                    'sale_date' => $saleDate,
                    'classification' => $row['classification'],
                    'insurance_status' => $row['insurance_status'],
                    'product_id' => $product->id,
                    'subproduct_id' => $subproduct->id,
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



                        // sale_date
                        // classification
                        // insurance_status
                        // product
                        // subproduct
                        // source
                        // division
                        // mortgagee
                        // affi_branch
                        // area
                        // alfc_branch
                        // loan_amount
                        // total_sum_insured
                        // policy_inception_date
                        // expiry_date
                        // policy_no
                        // plate_ conduction_no
                        // description
                        // mode_of_payment
                        // ra_comments
                        // admin_asst_remarks
                        // tracking_number
                        // mode_of_delivery
                        // policy_received_by
                        // policy_expiration_aging_days
                        // book_no
                        // filing_no
                        // remarks
                        // pid_received_date
                        // pid_status
                        // pid_completion_date