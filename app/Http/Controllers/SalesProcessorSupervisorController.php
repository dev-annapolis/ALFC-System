<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AssuredDetail;
use Illuminate\Http\Request;
use App\Models\InsuranceDetail;
use App\Models\RolePermission;

use Log;
use Auth;
use DB;

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

use App\Models\ChecklistTitle;
use App\Models\ChecklistOption;
use App\Models\InsuranceChecklist;

class SalesProcessorSupervisorController extends Controller
{
    public function SalesProcessorSupervisorIndex()
    {
        $teams = Team::where('status', 'active')->get();
        $sales_associates = SalesAssociate::where('status', 'active')->get();
        $sales_managers = SalesManager::where('status', 'active')->get();
        $providers = Provider::where('status', 'active')->get();
        $products = Product::where('status', 'active')->get();
        $subproducts = Subproduct::where('status', 'active')->get();

        $sources = Source::where('status', 'active')->get();
        $sourcebranches = Sourcebranch::where('status', 'active')->get();
        $ifgdfis = IfGdfi::where('status', 'active')->get();
        $areas = Area::where('status', 'active')->get();
        $alfcbranches = AlfcBranch::where('status', 'active')->get();
        $modeofpayments = ModeOfPayment::where('status', 'active')->get();

        $commissioners = Commissioner::where('status', 'active')->get();

        $teles = Tele::where('status', 'active')->get();

        return view('sps.index', compact('sales_associates', 'teams', 'sales_managers', 'providers', 'products', 'subproducts', 'sources', 'sourcebranches', 'ifgdfis', 'areas', 'alfcbranches', 'modeofpayments', 'teles', 'commissioners'));
    }

    public function spsIndexData()
    {
        // Fetch the insurance details along with related data through nested relationships
        $insuranceDetails = InsuranceDetail::with([
            'assuredDetail', // Load assureds with their related assuredDetails
            'paymentDetail',
            'salesAssociate.team',
            // 'branchManager',
            'source',
            'subproduct',
            'provider',
        ])
            ->where('verification_status', 'for_sps_verification')

            ->get()
            ->map(function ($insuranceDetail) {
                return [
                    'id' => $insuranceDetail->id ?? null,
                    'name' => $insuranceDetail->assuredDetail->name ?? null,
                    'contact_number' => $insuranceDetail->assuredDetail->contact_number ?? null,
                    'email' => $insuranceDetail->assuredDetail->email ?? null,
                    'issuance_code' => $insuranceDetail->issuance_code,
                    'sale_date' => $insuranceDetail->sale_date,
                    'good_as_sales_date' => $insuranceDetail->paymentDetail->date_of_good_as_sales ?? null,
                    'sales_associate' => $insuranceDetail->salesAssociate->name ?? null,
                    'sales_team' => $insuranceDetail->team->name ?? null,
                    // 'branch_manager' => $insuranceDetail->branchManager->name ?? null,
                    'source' => $insuranceDetail->source->name ?? null,
                    'subproduct' => $insuranceDetail->subproduct->name ?? null,
                    'policy_inception_date' => $insuranceDetail->policy_inception_date ?? null,
                    'provider' => $insuranceDetail->provider->name ?? null,
                    'ra_comments' => $insuranceDetail->ra_comments ?? ' ',
                    'sale_status' => $insuranceDetail->insurance_status ?? null,
                ];
            })
            ->unique(key: 'id'); // Remove duplicates based on 'id' field

        // Return data as JSON response
        return response()->json($insuranceDetails->values()); // Reset keys after unique filtering
    }

    public function fetchChecklist($insuranceDetailId)
    {
        Log::info($insuranceDetailId);

        // Check if there are any insurance checklist records
        $insuranceChecklists = InsuranceChecklist::where('insurance_detail_id', $insuranceDetailId)
            ->with('checklistOption.checklistTitle')
            ->get();

        if ($insuranceChecklists->isEmpty()) {
            // Return empty array if no records found
            return response()->json([]);
        }

        Log::info($insuranceChecklists);
        return response()->json($insuranceChecklists);
    }

    public function fetchChecklistTitles()
    {
        $checklistTitles = ChecklistTitle::all();
        return response()->json($checklistTitles);
    }
    public function fetchChecklistOptions($titleId)
    {
        $options = ChecklistOption::where('checklist_title_id', $titleId)->get();
        return response()->json($options);
    }
    public function saveChecklist(Request $request)
    {
        Log::info($request->all());

        $validatedData = $request->validate([
            'insurance_detail_id' => 'required|integer|exists:insurance_details,id',
            'options' => 'nullable|array',
            'options.*.checklist_option_id' => 'required|integer|exists:checklist_options,id',
        ]);

        $insuranceDetailId = $validatedData['insurance_detail_id'];
        $selectedOptions = collect($validatedData['options'] ?? []);

        // Get all options associated with the insurance detail
        $allOptions = ChecklistOption::whereHas('checklistTitle', function ($query) use ($insuranceDetailId) {
            $query->where('insurance_detail_id', $insuranceDetailId);
        })->get();

        foreach ($allOptions as $option) {
            // Check if the option is selected
            $isSelected = $selectedOptions->contains('checklist_option_id', $option->id);

            // Update or create the checklist entry
            InsuranceChecklist::updateOrCreate(
                [
                    'insurance_detail_id' => $insuranceDetailId,
                    'checklist_option_id' => $option->id,
                ],
                [
                    'completed' => $isSelected ? 1 : 0, // Mark as completed (1) if selected, otherwise set to 0
                ]
            );
        }

        return response()->json(['message' => 'Checklist updated successfully.']);
    }



}
