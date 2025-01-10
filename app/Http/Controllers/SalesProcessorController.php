<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Log;
use DB;

use App\Models\AssuredDetail;
use App\Models\InsuranceDetail;
use App\Models\CommissionDetail;
use App\Models\PaymentDetail;
use App\Models\InsuranceCommissioner;
use App\Models\SalesAssociate;
use App\Models\SalesManager;
use App\Models\Provider;
use App\Models\Product;
use App\Models\Subproduct;
use App\Models\Source;
use App\Models\SourceBranch;
use App\Models\IfGdfi;
use App\Models\SourceDivision;
use App\Models\Area;
use App\Models\AlfcBranch;
use App\Models\Team;
use App\Models\ModeOfPayment;
use App\Models\Commissioner;
use App\Models\ArAging;
use App\Models\ArAgingPivot;

use Illuminate\Support\Facades\Crypt;



class SalesProcessorController extends Controller
{
    public function showForm()
    {
        $clients = AssuredDetail::all();

        $teams = Team::select('name', 'id')->where('status', 'active')->get();
        $salesAssociates = SalesAssociate::select('name', 'id', 'team_id')->where('status', 'active')->get();
        $salesManagers = SalesManager::select('name', 'id', 'team_id')->where('status', 'active')->get();

        $providers = Provider::select('name', 'id')->where('status', 'active')->get();

        $products = Product::select('name', 'id')->where('status', 'active')->get();
        $subproducts = Subproduct::select('name', 'id', 'product_id')->where('status', 'active')->get();

        $sources = Source::select('name', 'id')->where('status', 'active')->get();
        $sourcebranches = SourceBranch::select('name', 'id')->where('status', 'active')->get();
        $ifGdfis = IfGdfi::select('name', 'id')->where('status', 'active')->get();
        $sourceDivisions = SourceDivision::with('source')->select('name', 'id', 'source_id')->where('status', 'active')->get();

        $areas = Area::select('name', 'id')->where('status', 'active')->get();
        $alfcbranches = AlfcBranch::select('name', 'id')->where('status', 'active')->get();
        $mops = ModeOfPayment::select('name', 'id')->where('status', 'active')->get();
        $commissioners = Commissioner::select('name', 'id')->where('status', 'active')->get();


        return view('form.form', compact(
            'clients',
            'teams',
            'salesAssociates',
            'salesManagers',
            'providers',
            'products',
            'subproducts',
            'sources',
            'sourcebranches',
            // 'ifGdfis',
            'sourceDivisions',
            'areas',
            'alfcbranches',
            'mops',
            'commissioners',
        ));
    }


    public function searchClients(Request $request)
    {
        $clientName = $request->input('query'); // Assuming the input field name is 'query'

        $clients = AssuredDetail::where('name', 'like', '%' . $clientName . '%')
            ->select('id', 'name', 'lot_number', 'street', 'barangay', 'city', 'country', 'email', 'contact_number') // Select only needed columns
            ->get();

        $clients->transform(function ($client) {
            $client->encrypted_id = Crypt::encryptString($client->id);
            return $client;
        });

        return response()->json($clients);
    }


    public function submitForm(Request $request)
    {
        DB::beginTransaction();
        try {
            $AssuredDetailId = null;

            if (!is_null($request->assuredIdValue)) {
                try {
                    $AssuredDetailId = Crypt::decryptString($request->assuredIdValue);
                } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                    Log::error('Decryption failed:', ['error' => $e->getMessage()]);
                }
            }

            if (is_null($AssuredDetailId)) {
                $AssuredDetail = AssuredDetail::create([
                    'name' => $request->assuredNameValue,
                    'lot_number' => $request->unitNoValue,
                    'street' => $request->streetValue,
                    'barangay' => $request->barangayValue,
                    'city' => $request->cityValue,
                    'country' => $request->countryValue,
                    'contact_number' => $request->assuredContactNumberValue,
                    'email' => $request->assuredEmailValue,
                ]);
                $AssuredDetailId = $AssuredDetail->id;
            }

            $InsuranceDetail = InsuranceDetail::create([
                'assured_detail_id' => $AssuredDetailId,
                'issuance_code' => $request->IssuanceCodeValue,
                'sale_date' => $request->saleDateValue,
                'classification' => $request->classificationValue,
                'insurance_status' => $request->saleStatusValue,
                'team_id' => $request->teamValue,
                'sales_associate_id' => $request->salesAssociateValue,
                'sales_manager_id' => $request->salesManagerValue,
                // 'book_number' => $request->assuredNameValue,
                // 'filing_number' => $request->assuredNameValue,
                // 'database_remarks' => $request->assuredNameValue,
                // 'pid_received_date' => $request->assuredNameValue,
                // 'pid_completion_date' => $request->assuredNameValue,
                // 'pid_status' => $request->assuredNameValue,
                'product_id' => $request->productValue,
                'subproduct_id' => $request->subProductValue,
                // 'product_type' => $request->productTypeValue,
                'source_id' => $request->sourceValue,
                'source_branch_id' => $request->sourceBranchValue,
                // 'if_gdfi_id' => $request->ifGdfiValue,
                'source_division_id' => $request->sourceDivisionIdValue,
                'mortgagee' => $request->mortgageeValue,
                'area_id' => $request->areaValue,
                'alfc_branch_id' => $request->alfcBranchValue,
                'policy_number' => $request->policyNumberValue,
                'plate_conduction_number' => $request->plateConductionNumberValue,
                'description' => $request->descriptionValue,
                'policy_inception_date' => $request->policyInceptionValue,
                'expiry_date' => $request->expiryDateValue,
                'mode_of_payment_id' => $request->mopValue,
                'loan_amount' => $request->loanAmountValue,
                'total_sum_insured' => $request->totalSumInsuredValue,
                // 'policy_expiration_aging' => $request->assuredNameValue,
            ]);
            $InsuranceDetailId = $InsuranceDetail->id;

            // $CommissionDetail = CommissionDetail::create([
            //     'insurance_detail_id' => $InsuranceDetailId,
            //     'gross_premium' => $request->grossPremiumValue,
            //     'discount' => $request->discountValue,
            //     'gross_premium_net_discounted' => $request->netOfDiscountValue,
            //     'amount_due_to_provider' => $request->amountDuetoProviderValue,
            //     'full_commission' => $request->fullCommissionValue,
            //     // 'travel_incentives' => $request->travelIncentivesValues,
            //     // 'offsetting' => $request->offSettingValues,
            //     // 'promo' => $request->promoValues,
            //     'vat' => $request->vatValues,
            //     'sales_credit' => $request->salesCreditValues,
            //     'sales_credit_percent' => $request->salesCreditPercentValues,
            //     'comm_deduct' => $request->commDeductValues,
            //     'total_commission' => $request->totalCommissionValues,
            // ]);

            $PaymentDetail = PaymentDetail::create([
                'insurance_detail_id' => $InsuranceDetailId,
                'payment_terms' => $request->paymentTermsValues,
                'due_date_start' => $request->dueDateStartValues,
                'due_date_end' => $request->dueDateEndValues,
                'first_payment_schedule' => $request->paymentTermsDate[0]['first_payment_schedule_date'] ?? null,
                'first_payment_amount' => $request->paymentTermsDate[0]['first_payment_schedule_amount'] ?? null,
                'second_payment_schedule' => $request->paymentTermsDate[1]['second_payment_schedule_date'] ?? null,
                'second_payment_amount' => $request->paymentTermsDate[1]['second_payment_schedule_amount'] ?? null,
                'third_payment_schedule' => $request->paymentTermsDate[2]['third_payment_schedule_date'] ?? null,
                'third_payment_amount' => $request->paymentTermsDate[2]['third_payment_schedule_amount'] ?? null,
                'fourth_payment_schedule' => $request->paymentTermsDate[3]['fourth_payment_schedule_date'] ?? null,
                'fourth_payment_amount' => $request->paymentTermsDate[3]['fourth_payment_schedule_amount'] ?? null,
                'fifth_payment_schedule' => $request->paymentTermsDate[4]['fifth_payment_schedule_date'] ?? null,
                'fifth_payment_amount' => $request->paymentTermsDate[4]['fifth_payment_schedule_amount'] ?? null,
                'sixth_payment_schedule' => $request->paymentTermsDate[5]['sixth_payment_schedule_date'] ?? null,
                'sixth_payment_amount' => $request->paymentTermsDate[5]['sixth_payment_schedule_amount'] ?? null,
                'seventh_payment_schedule' => $request->paymentTermsDate[6]['seventh_payment_schedule_date'] ?? null,
                'seventh_payment_amount' => $request->paymentTermsDate[6]['seventh_payment_schedule_amount'] ?? null,
                'eight_payment_schedule' => $request->paymentTermsDate[7]['eighth_payment_schedule_date'] ?? null,
                'eight_payment_amount' => $request->paymentTermsDate[7]['eighth_payment_schedule_amount'] ?? null,
                'provision_receipt' => $request->prNumberValues,
                'initial_payment' => $request->initialPaymentValues,
                // 'for_billing' => $request->forBillingValues,
                // 'over_under_payment' => $request->overUnderPaymentValues,
                // 'date_of_good_as_sales' => $request->dateGoodSalesValues,
                // 'payment_status' => $request->statusPaymentValues,
                'gross_premium' => $request->grossPremiumValue,
                'discount' => $request->discountValue,
                'gross_premium_net_discounted' => $request->netOfDiscountValue,
                'amount_due_to_provider' => $request->amountDuetoProviderValue,
                'full_commission' => $request->fullCommissionValue,
                'vat' => $request->vatValues,
                'sales_credit' => $request->salesCreditValues,
                'sales_credit_percent' => $request->salesCreditPercentValues,
                'comm_deduct' => $request->commDeductValues,
                'total_commission' => $request->totalCommissionValues,
                'provider_id' => $request->providerValue,

            ]);

            foreach ($request->commissionsSelect as $commission) {
                $InsuranceCommissioner = InsuranceCommissioner::create([
                    'insurance_detail_id' => $InsuranceDetailId,
                    'commissioner_id' => $commission['commissionType'],
                    'commissioner_name' => $commission['commissionName'],
                    'amount' => $commission['commissionAmount'],
                ]);
            }
            $grossPremium = $request->grossPremiumValue;
            $initialPayment = $request->initialPaymentValues;

            // Calculate the balance (gross_premium - total_outstanding)
            $balance = $grossPremium - $initialPayment;

            $arAging = ArAging::create([
                'insurance_detail_id' => $InsuranceDetailId,
                'issuance_code' => $request->IssuanceCodeValue,
                'name' => $request->assuredNameValue,
                'due_date' => $request->dueDateStartValues,
                'terms' => $request->paymentTermsValues,
                'team' => $request->teamValue,
                'policy_number' => $request->policyNumberValue,
                'sale_date' => $request->saleDateValue,
                'mode_of_payment' => $request->mopValue,
                'gross_premium' => $request->grossPremiumValue,
                'total_outstanding' => $request->initialPaymentValues,
                'balance' => $balance, // Assuming the balance is the same as total outstanding initially
            ]);

            // Create AR Aging Pivots
            $terms = (int) $request->paymentTermsValues;
            $paymentDetail = PaymentDetail::where('insurance_detail_id', $InsuranceDetailId)->first();

            // Validate that $paymentDetail exists
            if ($paymentDetail) {
                $paymentSchedules = [
                    ['schedule' => $paymentDetail->first_payment_schedule, 'amount' => $paymentDetail->first_payment_amount],
                    ['schedule' => $paymentDetail->second_payment_schedule, 'amount' => $paymentDetail->second_payment_amount],
                    ['schedule' => $paymentDetail->third_payment_schedule, 'amount' => $paymentDetail->third_payment_amount],
                    ['schedule' => $paymentDetail->fourth_payment_schedule, 'amount' => $paymentDetail->fourth_payment_amount],
                    ['schedule' => $paymentDetail->fifth_payment_schedule, 'amount' => $paymentDetail->fifth_payment_amount],
                    ['schedule' => $paymentDetail->sixth_payment_schedule, 'amount' => $paymentDetail->sixth_payment_amount],
                    ['schedule' => $paymentDetail->seventh_payment_schedule, 'amount' => $paymentDetail->seventh_payment_amount],
                    ['schedule' => $paymentDetail->eight_payment_schedule, 'amount' => $paymentDetail->eight_payment_amount],
                ];

                // Create AR Aging Pivots
                $terms = (int) $request->paymentTermsValues;

                for ($i = 0; $i < min($terms, 8); $i++) {
                    $label = $i === 0 ? 'current' : (($i - 1) * 30 + 1) . '-' . ($i * 30);
                    $schedule = $paymentSchedules[$i];

                    ArAgingPivot::create([
                        'ar_aging_id' => $arAging->id,
                        'label' => $label,
                        'payment_amount' => $schedule['amount'],
                        'payment_schedule' => $schedule['schedule'],
                        'paid_amount' => null, // Set for current
                        'paid_schedule' => null, // Set for current
                        'reference_number' => null,
                        'ra_remarks' => null,
                        'tele_remarks' => null,
                        'paid' => $i === 0, // Set current to 1, others to 0
                    ]);
                }
            } else {
                // Handle case where PaymentDetail is not found
                throw new \Exception('PaymentDetail not found for InsuranceDetail ID: ' . $InsuranceDetailId);
            }

            DB::commit();
            Log::info("Created " . $AssuredDetail->name);
            return response()->json([
                'message' => 'Form data received successfully.',
                'AssuredDetailId' => $AssuredDetailId,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Transaction failed:', ['error' => $e->getMessage()]);

            return response()->json([
                'message' => 'An error occurred while processing the form data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

}
