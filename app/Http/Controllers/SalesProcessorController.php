<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Log;

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
use App\Models\Area;
use App\Models\AlfcBranch;
use App\Models\Team;
use App\Models\ModeOfPayment;
use App\Models\Commissioner;
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
            'ifGdfis',
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
        Log::info($request->all());
        $AssuredDetailId = null;

        if (!is_null($request->assuredIdValue)) {
            try {
                // Decrypt the assuredIdValue
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

        // $assuredNameValue = $request->assuredNameValue;
        // $assuredIdValue = $request->assuredIdValue;
        // $fullAddressValue = $request->fullAddressValue;
        // $unitNoValue = $request->unitNoValue;
        // $streetValue = $request->streetValue;
        // $barangayValue = $request->barangayValue;
        // $cityValue = $request->cityValue;
        // $countryValue = $request->countryValue;
        // $assuredEmailValue = $request->assuredEmailValue;
        // $assuredContactNumberValue = $request->assuredContactNumberValue;

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
            'provider_id' => $request->providerValue,
            'product_id' => $request->productValue,
            'subproduct_id' => $request->subProductValue,
            'product_type' => $request->productTypeValue,
            'source_id' => $request->sourceValue,
            'source_branch_id' => $request->sourceBranchValue,
            'if_gdfi_id' => $request->ifGdfiValue,
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

        // $IssuanceCodeValue = $request->IssuanceCodeValue;
        // $classificationValue = $request->classificationValue;
        // $saleStatusValue = $request->saleStatusValue;
        // $saleDateValue = $request->saleDateValue;
        // $teamValue = $request->teamValue;
        // $salesAssociateValue = $request->salesAssociateValue;
        // $salesManagerValue = $request->salesManagerValue;
        // $providerValue = $request->providerValue;
        // $policyNumberValue = $request->policyNumberValue;
        // $policyInceptionValue = $request->policyInceptionValue;
        // $expiryDateValue = $request->expiryDateValue;
        // $productValue = $request->productValue;
        // $subProductValue = $request->subProductValue;
        // $productTypeValue = $request->productTypeValue;
        // $sourceValue = $request->sourceValue;
        // $sourceBranchValue = $request->sourceBranchValue;
        // $ifGdfiValue = $request->ifGdfiValue;
        // $mortgageeValue = $request->mortgageeValue;
        // $areaValue = $request->areaValue;
        // $alfcBranchValue = $request->alfcBranchValue;
        // $plateConductionNumberValue = $request->plateConductionNumberValue;
        // $descriptionValue = $request->descriptionValue;
        // $loanAmountValue = $request->loanAmountValue;
        // $totalSumInsuredValue = $request->totalSumInsuredValue;
        // $mopValue = $request->mopValue;

        $CommissionDetail = CommissionDetail::create([
            'insurance_detail_id' => $InsuranceDetailId,
            'gross_premium' => $request->grossPremiumValue,
            'discount' => $request->discountValue,
            'gross_premium_net_discounted' => $request->netOfDiscountValue,
            'amount_due_to_provider' => $request->amountDuetoProviderValue,
            'full_commission' => $request->fullCommissionValue,
            'travel_incentives' => $request->travelIncentivesValues,
            'offsetting' => $request->offSettingValues,
            'promo' => $request->promoValues,
            'vat' => $request->vatValues,
            'sales_credit' => $request->salesCreditValues,
            'sales_credit_percent' => $request->salesCreditPercentValues,
            'comm_deduct' => $request->commDeductValues,
            'total_commission' => $request->totalCommissionValues,
        ]);

        // $grossPremiumValue = $request->grossPremiumValue;
        // $discountValue = $request->discountValue;
        // $netOfDiscountValue = $request->netOfDiscountValue;
        // $amountDuetoProviderValue = $request->amountDuetoProviderValue;
        // $fullCommissionValue = $request->fullCommissionValue;
        // $travelIncentivesValues = $request->travelIncentivesValues;
        // $offSettingValues = $request->offSettingValues;
        // $promoValues = $request->promoValues;
        // $totalCommissionValues = $request->totalCommissionValues;
        // $commDeductValues = $request->commDeductValues;
        // $vatValues = $request->vatValues;
        // $salesCreditValues = $request->salesCreditValues;
        // $salesCreditPercentValues = $request->salesCreditPercentValues;

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
            'for_billing' => $request->forBillingValues,
            'over_under_payment' => $request->overUnderPaymentValues,
            'date_of_good_as_sales' => $request->dateGoodSalesValues,
            'payment_status' => $request->statusPaymentValues,
        ]);

        // $paymentTermsValues = $request->paymentTermsValues;
        // $dueDateStartValues = $request->dueDateStartValues;
        // $dueDateEndValues = $request->dueDateEndValues;
        // $initialPaymentValues = $request->initialPaymentValues;
        // $dateGoodSalesValues = $request->dateGoodSalesValues;
        // $forBillingValues = $request->forBillingValues;
        // $overUnderPaymentValues = $request->overUnderPaymentValues;
        // $prNumberValues = $request->prNumberValues;
        // $statusPaymentValues = $request->statusPaymentValues;
        // $payment_0_date = $request->paymentTermsDate[0]['first_payment_schedule_date'];
        // $payment_0_amount = $request->paymentTermsDate[0]['first_payment_schedule_amount'];
        // $payment_1_date = $request->paymentTermsDate[1]['second_payment_schedule_date'];
        // $payment_1_amount = $request->paymentTermsDate[1]['second_payment_schedule_amount'];
        // $payment_2_date = $request->paymentTermsDate[2]['third_payment_schedule_date'];
        // $payment_2_amount = $request->paymentTermsDate[2]['third_payment_schedule_amount'];
        // $payment_3_date = $request->paymentTermsDate[3]['fourth_payment_schedule_date'];
        // $payment_3_amount = $request->paymentTermsDate[3]['fourth_payment_schedule_amount'];
        // $payment_4_date = $request->paymentTermsDate[4]['fifth_payment_schedule_date'];
        // $payment_4_amount = $request->paymentTermsDate[4]['fifth_payment_schedule_amount'];

        // Commissions array
        $commission_0_type = $request->commissionsSelect[0]['commissionType'];
        $commission_0_name = $request->commissionsSelect[0]['commissionName'];
        $commission_0_amount = $request->commissionsSelect[0]['commissionAmount'];

        $commission_1_type = $request->commissionsSelect[1]['commissionType'];
        $commission_1_name = $request->commissionsSelect[1]['commissionName'];
        $commission_1_amount = $request->commissionsSelect[1]['commissionAmount'];

        $commission_2_type = $request->commissionsSelect[2]['commissionType'];
        $commission_2_name = $request->commissionsSelect[2]['commissionName'];
        $commission_2_amount = $request->commissionsSelect[2]['commissionAmount'];

        

        return response()->json([
            'message' => 'Form data received successfully.',
            // 'decryptedId' => $decryptedId,
        ]);
    }



}
