<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AssuredDetail;
use Illuminate\Http\Request;
use App\Models\InsuranceDetail;
use App\Models\Assured;
use App\Models\RolePermission;
use Log;
use Auth;
use DB;

class SalesReportController extends Controller
{
    public function salesReportIndex()
    {
        return view('salesreport.index');
    }

    public function salesReportData()
    {
        // Fetch the insurance details along with related data through nested relationships
        $insuranceDetails = InsuranceDetail::with([
            'assured.assuredDetail', // Load assureds with their related assuredDetails
            'paymentDetail',
            'salesAssociate.team',
            'branchManager',
            'source',
            'subproduct',
            'provider',
        ])
            ->get()
            ->map(function ($insuranceDetail) {
                return [
                    'id' => $insuranceDetail->id ?? null,
                    'name' => $insuranceDetail->assured->name ?? null,
                    'contact_number' => $insuranceDetail->assured->assuredDetail->contact_number ?? null,
                    'email' => $insuranceDetail->assured->assuredDetail->email ?? null,
                    'issuance_code' => $insuranceDetail->issuance_code,
                    'sale_date' => $insuranceDetail->sale_date,
                    'good_as_sales_date' => $insuranceDetail->paymentDetail->good_as_sales_date ?? null,
                    'sales_associate' => $insuranceDetail->salesAssociate->name ?? null,
                    'sales_team' => $insuranceDetail->salesAssociate->team->name ?? null,
                    'branch_manager' => $insuranceDetail->branchManager->name ?? null,
                    'source' => $insuranceDetail->source->name ?? null,
                    'subproduct' => $insuranceDetail->subproduct->name ?? null,
                    'policy_inception_date' => $insuranceDetail->policy_inception_date ?? null,
                    'provider' => $insuranceDetail->provider->name ?? null,
                    'sale_status' => $insuranceDetail->sale_status ?? null,
                ];
            })
            ->unique('id'); // Remove duplicates based on 'id' field

        // Return data as JSON response
        return response()->json($insuranceDetails->values()); // Reset keys after unique filtering
    }


    public function showInsuranceDetails($id)
    {
        $user = Auth::user();
        $role = $user->role;

        $permissions = RolePermission::where('role_id', $role->id)
            ->where('can_view', 1)
            ->get();

        if ($permissions->isEmpty()) {
            // Log::warning("No permissions found for user role ID: {$role->id}");
            return response()->json(['message' => 'No permissions found'], 403);
        } else {
            // Log::info("Permissions found for role ID: {$role->id}");
        }

        $data = [];

        $tables = [
            'assured_details',
            //'assureds',
            'insurance_details',
            // 'commision_details',
            // 'collection_details',
            // 'payment_details',
            // 'insurance_commisioners',
            // 'sales_associates',
            // 'branch_managers',
            // 'products',
            // 'subproducts',
            // 'sources',
            // 'source_branches',
            // 'if_gdfis',
            // 'areas',
            // 'alfc_branches',
            // 'mode_of_payments',
            // 'providers',
        ];

        foreach ($tables as $tableName) {
            $allowedColumns = $permissions->where('table_name', $tableName)
                ->pluck('column_name')
                ->toArray();

            if (count($allowedColumns) > 0) {
                if ($tableName == 'insurance_details') {
                    $query = InsuranceDetail::with([
                        'assured.assuredDetail',
                        'salesAssociate',
                        'branchManager',
                        'product',
                        'subproduct',
                        'source',
                        'sourceBranch',
                        'ifGdfi',
                        'area',
                        'alfcBranch',
                        'modeOfPayment',
                        'provider',
                    ])->where('insurance_details.id', $id);

                    $columnsWithPrefix = array_map(function ($column) use ($tableName) {
                        return "{$tableName}.{$column}";
                    }, $allowedColumns);

                    $records = $query->select($columnsWithPrefix)->first();

                    if ($records) {
                        $records->assured_id = optional($records->assured)->name;
                        $records->sales_associate_id = optional($records->salesAssociate)->name;
                        $records->branch_manager_id = optional($records->branchManager)->name;
                        $records->product_id = optional($records->product)->name;
                        $records->subproduct_id = optional($records->subproduct)->name;
                        $records->source_id = optional($records->source)->name;
                        $records->source_branch_id = optional($records->sourceBranch)->name;
                        $records->if_gdfi_id = optional($records->ifGdfi)->name;
                        $records->area_id = optional($records->area)->name;
                        $records->alfc_branch_id = optional($records->alfcBranch)->name;
                        $records->mode_of_payment_id = optional($records->modeOfPayment)->name;
                        $records->provider_id = optional($records->provider)->name;

                        $data[$tableName] = $records;
                    } else {
                        $data[$tableName] = null;
                    }
                } elseif ($tableName == 'assured_details') {
                    // Query AssuredDetail based on related InsuranceDetail by navigating through Assured
                    $query = AssuredDetail::whereHas('assured.insuranceDetails', function ($q) use ($id) {
                        $q->where('insurance_details.id', $id);
                    });



                    $assuredName = InsuranceDetail::with('assured')
                        ->where('insurance_details.id', $id)
                        ->first()
                        ->assured
                        ->name;

                    // Fetch the columns with the table prefix
                    $columnsWithPrefix = array_map(function ($column) use ($tableName) {
                        return "{$tableName}.{$column}";
                    }, $allowedColumns);

                    // Include 'assured' relation to access assured name
                    $records = $query->select($columnsWithPrefix)->first();

                    if ($records) {
                        // Add the 'assured_name' property manually and place it first
                        $records->assured_name = $assuredName;

                        // To ensure that 'assured_name' is first, we'll use a new stdClass object
                        $recordWithAssuredNameFirst = new \stdClass();

                        // Add 'assured_name' first
                        $recordWithAssuredNameFirst->assured_name = $assuredName;

                        // Now, loop through the existing columns and add them to the new object
                        foreach ($records->getAttributes() as $key => $value) {
                            $recordWithAssuredNameFirst->$key = $value;
                        }

                        // Assign the new object to $data
                        $data[$tableName] = $recordWithAssuredNameFirst;
                    } else {
                        $data[$tableName] = null;
                    }
                }



            } else {
                Log::info("No allowed columns for table: {$tableName}");
            }
        }

        return response()->json($data);
    }






}
