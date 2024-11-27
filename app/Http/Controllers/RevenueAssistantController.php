<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\SalesAssociate;
use App\Models\SalesManager;
use App\Models\Provider;
use App\Models\Product;
use App\Models\Subproduct;
use App\Models\Source;
use App\Models\Sourcebranch;
use App\Models\IfGdfi;
use App\Models\Area;
use App\Models\AlfcBranch;
use App\Models\ModeOfPayment;
use App\Models\Tele;
use App\Models\Commissioner;
use App\Models\InsuranceDetail;
use App\Models\RolePermission;

use Illuminate\Http\Request;
use Log;
use Auth;

class RevenueAssistantController extends Controller
{
    public function RevenueAssistantIndex()
    {
        return view('ra.index');
    }

    public function raIndexData()
    {
        $insuranceDetails = InsuranceDetail::with([
            'assuredDetail', // Load assureds with their related assuredDetails
            'paymentDetail',
            'commissionDetail',
            'salesAssociate.team',
            'modeOfPayment',
            'source',
            'subproduct',
            'provider',
        ])
            ->get()
            ->map(function ($insuranceDetail) {
                return [
                    'id' => $insuranceDetail->id ?? null,
                    'issuance_code' => $insuranceDetail->issuance_code ?? null,
                    'name' => $insuranceDetail->assuredDetail->name ?? null,
                    'sale_date' => $insuranceDetail->sale_date ?? null,
                    'policy_number' => $insuranceDetail->policy_number ?? null,
                    'plate_conduction_number' => $insuranceDetail->plate_conduction_number ?? null,
                    'mode_of_payment' => $insuranceDetail->modeOfPayment->name ?? null,
                    'pr_number' => $insuranceDetail->paymentDetail->provision_receipt ?? null,
                    'gross_premium' => $insuranceDetail->commissionDetail->gross_premium ?? null,
                    'discount' => $insuranceDetail->commissionDetail->discount ?? null,
                    'amount_due_to_provider' => $insuranceDetail->commissionDetail->amount_due_to_provider ?? null,
                    'sales_credit' => $insuranceDetail->commissionDetail->sales_credit ?? null,
                    'sales_credit_percent' => $insuranceDetail->commissionDetail->sales_credit_percent ?? null,
                    'date_of_good_as_sales' => $insuranceDetail->paymentDetail->date_of_good_as_sales ?? null,
                    'status' => $insuranceDetail->insurance_status ?? null,
                    'ra_comments' => $insuranceDetail->ra_comments ?? null,
                ];
            })
            ->unique(key: 'id'); // Remove duplicates based on 'id' field

        // Return data as JSON response
        return response()->json($insuranceDetails->values()); // Reset keys after unique filtering
    }
}
