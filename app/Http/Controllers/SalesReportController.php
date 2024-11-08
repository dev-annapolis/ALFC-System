<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InsuranceDetail;
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
        Log::info("Processing insurance details for ID: {$id}");

        $user = Auth::user();
        $role = $user->role;

        // Log user and role information
        Log::info("User: {$user->name}, Role: {$role->name}");

        // Fetch permissions for the user's role with `can_view` set to 1
        $permissions = RolePermission::where('role_id', $role->id)
            ->where('can_view', 1)
            ->get();

        if ($permissions->isEmpty()) {
            Log::warning("No permissions found for user role ID: {$role->id}");
            return response()->json(['message' => 'No permissions found'], 403);
        } else {
            Log::info("Permissions found for role ID: {$role->id}");
        }

        // Initialize the data array for the selected record
        $data = [];

        // Define the tables to retrieve data from based on permissions
        $tables = [
            'insurance_details',
            'assureds',
            'assured_details',
            'sales_associates',
            'branch_managers',
            'products',
            'subproducts',
            'sources',
            'source_branches',
            'if_gdfis',
            'areas',
            'alfc_branches',
            'mode_of_payments',
            'providers',
            'insurance_commisioners',
            'commision_details',
            'payment_details',
            'collection_details',
        ];

        // Loop over each table and check for allowed columns
        foreach ($tables as $tableName) {
            Log::info("Processing table: {$tableName}");

            // Get allowed columns for this table based on permissions
            $allowedColumns = $permissions->where('table_name', $tableName)
                ->pluck('column_name')
                ->toArray();

            // If there are allowed columns, proceed to build the query
            if (count($allowedColumns) > 0) {
                Log::info("Columns allowed for table {$tableName}: " . implode(', ', $allowedColumns));

                // Start building the query
                $records = DB::table($tableName);

                if ($tableName == 'insurance_details') {
                    // Fetch the main record along with related data
                    $records = DB::table('insurance_details')
                        ->where('insurance_details.id', $id)
                        ->distinct()
                        ->leftJoin('assureds', 'insurance_details.assured_id', '=', 'assureds.id')
                        ->leftJoin('assured_details', 'assureds.assured_detail_id', '=', 'assured_details.id')
                        ->leftJoin('sales_associates', 'insurance_details.sales_associate_id', '=', 'sales_associates.id')
                        ->leftJoin('branch_managers', 'insurance_details.branch_manager_id', '=', 'branch_managers.id')
                        ->leftJoin('products', 'insurance_details.product_id', '=', 'products.id')
                        ->leftJoin('subproducts', 'insurance_details.subproduct_id', '=', 'subproducts.id')
                        ->leftJoin('sources', 'insurance_details.source_id', '=', 'sources.id')
                        ->leftJoin('source_branches', 'insurance_details.source_branch_id', '=', 'source_branches.id')
                        ->leftJoin('if_gdfis', 'insurance_details.if_gdfi_id', '=', 'if_gdfis.id')
                        ->leftJoin('areas', 'insurance_details.area_id', '=', 'areas.id')
                        ->leftJoin('alfc_branches', 'insurance_details.alfc_branch_id', '=', 'alfc_branches.id')
                        ->leftJoin('mode_of_payments', 'insurance_details.mode_of_payment_id', '=', 'mode_of_payments.id')
                        ->leftJoin('providers', 'insurance_details.provider_id', '=', 'providers.id')
                        ->leftJoin('insurance_commisioners', 'insurance_details.id', '=', 'insurance_commisioners.insurance_detail_id')
                        ->leftJoin('commision_details', 'insurance_details.id', '=', 'commision_details.insurance_detail_id')
                        ->leftJoin('payment_details', 'insurance_details.id', '=', 'payment_details.insurance_detail_id')
                        ->leftJoin('collection_details', 'insurance_details.id', '=', 'collection_details.insurance_detail_id');
                } elseif ($tableName == 'assureds') {
                    // Ensure that the `assureds` table only shows entries related to the specific insurance detail
                    $records = DB::table('assureds')
                        ->join('insurance_details', 'assureds.id', '=', 'insurance_details.assured_id')
                        ->where('insurance_details.id', $id);
                } elseif (\Schema::hasColumn($tableName, 'insurance_detail_id')) {
                    // For other tables that have `insurance_detail_id`, filter by the ID
                    $records->where('insurance_detail_id', $id);
                }

                // Add table name prefix to each column to avoid ambiguity
                $columnsWithPrefix = array_map(function ($column) use ($tableName) {
                    return "{$tableName}.{$column}";
                }, $allowedColumns);

                // Apply select to retrieve only allowed columns with prefixed table names
                $records = $records->select($columnsWithPrefix);

                // Fetch the records and add them to the data array
                Log::info("Fetching data from table: {$tableName}");
                $data[$tableName] = $records->get();
                Log::info("Data retrieved for table: {$tableName}");
            } else {
                Log::info("No allowed columns for table: {$tableName}");
            }
        }

        // Log the final data
        Log::info("Insurance details data retrieved for ID: {$id}", ['data' => $data]);

        // Return data as JSON response
        return response()->json($data);
    }






}
