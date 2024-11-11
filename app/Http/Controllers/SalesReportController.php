<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AssuredDetail;
use Illuminate\Http\Request;
use App\Models\InsuranceDetail;
use App\Models\CommisionDetail;
use App\Models\InsuranceCommisioner;
use App\Models\Assured;
use App\Models\PaymentDetail;
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
            return response()->json(['message' => 'No permissions found'], 403);
        }

        $data = [];
        $tables = [
            'assured_details',
            'insurance_details',
            'payment_details',
            'commision_details',
            'insurance_commisioners'
        ];

        foreach ($tables as $tableName) {
            $allowedColumns = $permissions->where('table_name', $tableName)
                ->pluck('column_name')
                ->toArray();

            if (count($allowedColumns) > 0) {
                if ($tableName == 'insurance_details') {
                    try {
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
                            // Define an array of field mappings for replacement
                            $fieldsToReplace = [
                                'assured_id' => 'assured',
                                'sales_associate_id' => 'salesAssociate',
                                'branch_manager_id' => 'branchManager',
                                'product_id' => 'product',
                                'subproduct_id' => 'subproduct',
                                'source_id' => 'source',
                                'source_branch_id' => 'sourceBranch',
                                'if_gdfi_id' => 'ifGdfi',
                                'area_id' => 'area',
                                'alfc_branch_id' => 'alfcBranch',
                                'mode_of_payment_id' => 'modeOfPayment',
                                'provider_id' => 'provider',
                            ];

                            // Convert the object to an array using toArray() to get only the model attributes
                            $recordsArray = $records->toArray();  // Using toArray() method

                            // Create a new array to hold the modified records
                            $newRecordsArray = [];

                            // Iterate through the original record fields
                            foreach ($recordsArray as $key => $value) {
                                // If the field is in the replacement map, replace it
                                if (isset($fieldsToReplace[$key])) {
                                    // Replace _id with _name and get the corresponding name
                                    $relation = $fieldsToReplace[$key];
                                    if ($key === 'assured_id') {
                                        // Special case for assured_id to become assured_name
                                        $newRecordsArray['assured_name'] = optional($records->{$relation})->name ?? "***";
                                    } else {
                                        // For all other fields, just remove the _id suffix and replace it with related name
                                        $newKey = str_replace('_id', '', $key);  // Remove _id from the key
                                        $newRecordsArray[$newKey . '_name'] = optional($records->{$relation})->name ?? "***";
                                    }
                                } else {
                                    // If the field value is null, show '***'
                                    $newRecordsArray[$key] = $value ?? "***";
                                }
                            }

                            // Convert back to object
                            $records = (object) $newRecordsArray;

                            // Store the modified records in the $data array
                            $data[$tableName] = $records;
                        } else {
                            $data[$tableName] = null;
                        }
                    } catch (\Exception $e) {
                        Log::error("Error processing insurance_details: " . $e->getMessage());
                        $data[$tableName] = null;
                    }
                } elseif ($tableName == 'assured_details') {
                    try {
                        $query = AssuredDetail::whereHas('assured.insuranceDetails', function ($q) use ($id) {
                            $q->where('insurance_details.id', $id);
                        });

                        $assuredName = InsuranceDetail::with('assured')
                            ->where('insurance_details.id', $id)
                            ->first()
                            ->assured
                            ->name;

                        $columnsWithPrefix = array_map(function ($column) use ($tableName) {
                            return "{$tableName}.{$column}";
                        }, $allowedColumns);

                        $records = $query->select($columnsWithPrefix)->first();

                        if ($records) {
                            $records->assured_name = $assuredName;

                            $recordWithAssuredNameFirst = new \stdClass();
                            $recordWithAssuredNameFirst->assured_name = $assuredName;

                            foreach ($records->getAttributes() as $key => $value) {
                                $recordWithAssuredNameFirst->$key = $value;
                            }

                            $data[$tableName] = $recordWithAssuredNameFirst;
                        } else {
                            $data[$tableName] = null;
                        }
                    } catch (\Exception $e) {
                        Log::error("Error processing assured_details: " . $e->getMessage());
                        $data[$tableName] = null;
                    }
                } elseif ($tableName == 'payment_details') {
                    try {
                        $query = PaymentDetail::where('insurance_detail_id', $id);

                        $columnsWithPrefix = array_map(function ($column) use ($tableName) {
                            return "{$tableName}.{$column}";
                        }, $allowedColumns);

                        $records = $query->select($columnsWithPrefix)->first();

                        if ($records) {
                            $data[$tableName] = $records;
                        } else {
                            $data[$tableName] = null;
                        }
                    } catch (\Exception $e) {
                        Log::error("Error processing payment_details: " . $e->getMessage());
                        $data[$tableName] = null;
                    }
                } elseif ($tableName == 'commision_details') {
                    try {
                        $query = CommisionDetail::where('insurance_detail_id', $id);

                        $columnsWithPrefix = array_map(function ($column) use ($tableName) {
                            return "{$tableName}.{$column}";
                        }, $allowedColumns);

                        $records = $query->select($columnsWithPrefix)->first();

                        if ($records) {
                            $data[$tableName] = $records;
                        } else {
                            $data[$tableName] = null;
                        }
                    } catch (\Exception $e) {
                        Log::error("Error processing commision_details: " . $e->getMessage());
                        $data[$tableName] = null;
                    }
                } elseif ($tableName == 'insurance_commisioners') {
                    Log::info("Processing table: $tableName");

                    try {
                        // Query InsuranceCommissioner for the given insurance_detail_id
                        $query = InsuranceCommisioner::with('commisioner') // Eager load the commisioner relationship
                            ->where('insurance_detail_id', $id);

                        // Prefix the columns in the insurance_commissioners table
                        $columnsWithPrefix = array_map(function ($column) use ($tableName) {
                            return "{$tableName}.{$column}";
                        }, $allowedColumns);

                        // Log::info("Columns selected: ", $columnsWithPrefix);

                        // Retrieve the records without the join, using the relationship to get commisioner_name
                        $records = $query
                            ->select($columnsWithPrefix) // Select the necessary columns from insurance_commissioners table
                            ->get();

                        // Check if there are any records
                        if ($records->isNotEmpty()) {
                            // Initialize an empty array to store each record's data
                            $data[$tableName] = [];

                            // Iterate over each record and store the details
                            foreach ($records as $record) {
                                $data[$tableName][] = [
                                    'commisioner_name' => optional($record->commisioner)->name ?? "***", // Access commisioner name via the relationship
                                    'amount' => $record->amount ?? "***",
                                ];
                            }

                            // Log::info("Data formatted for table: $tableName", $data[$tableName]);
                        } else {
                            $data[$tableName] = null;
                            // Log::info("No records found for insurance_detail_id: $id");
                        }
                    } catch (\Exception $e) {
                        Log::error("Error processing table: $tableName", ['error' => $e->getMessage()]);
                        $data[$tableName] = null;
                    }
                } else {
                    Log::info("No allowed columns for table: {$tableName}");
                }
            }

        }
        return response()->json($data);

    }
}





