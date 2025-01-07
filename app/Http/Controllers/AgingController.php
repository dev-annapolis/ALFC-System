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
use App\Models\Area;
use App\Models\AlfcBranch;
use App\Models\Team;
use App\Models\ModeOfPayment;
use App\Models\Commissioner;
use App\Models\ArAging;
use App\Models\ArAgingPivot;
use App\Helpers\DateHelper; // Use the helper if in a helper file or service

class AgingController extends Controller
{
    public function agingIndex()
    {
        return view('aging.index');
    }
    public function agingTableData()
    {
        $data = ArAging::select(
            'ar_agings.id',
            'ar_agings.insurance_detail_id',
            'ar_agings.issuance_code',
            'ar_agings.name',
            // Concatenate the first and last payment_schedule
            DB::raw('CONCAT(
                (SELECT payment_schedule FROM ar_aging_pivots WHERE ar_aging_id = ar_agings.id ORDER BY payment_schedule ASC LIMIT 1),
                " to ",
                (SELECT payment_schedule FROM ar_aging_pivots WHERE ar_aging_id = ar_agings.id ORDER BY payment_schedule DESC LIMIT 1)
            ) as due_date'),
            'ar_agings.terms',
            'ar_agings.policy_number',
            'ar_agings.sale_date',
            'ar_agings.gross_premium',
            'ar_agings.total_outstanding',
            'ar_agings.balance',
            'teams.name as team',
            'mode_of_payments.name as mode_of_payment' // Fetch the name of the payment mode
        )
            ->leftJoin('teams', 'ar_agings.team', '=', 'teams.id') // Join with teams table
            ->leftJoin('mode_of_payments', 'ar_agings.mode_of_payment', '=', 'mode_of_payments.id') // Join with mode_of_payments table
            ->get();



        // Return JSON response
        return response()->json($data);
    }

    public function getArAgingPivots($id)
    {
        // Retrieve selected fields from the ArAgingPivot model for the given ArAging ID
        $pivots = ArAgingPivot::select(
            'label',
            'payment_amount',
            'payment_schedule',
            'paid_amount',
            'paid_schedule',
            'reference_number',
            'ra_remarks',
            'tele_remarks',
            'paid'
        )
            ->where('ar_aging_id', $id)  // Use $id here instead of $arAgingId
            ->get();

        // Return the data as a JSON response
        return response()->json($pivots);
    }
}
