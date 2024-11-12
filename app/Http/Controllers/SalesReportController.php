<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AssuredDetail;
use Illuminate\Http\Request;
use App\Models\InsuranceDetail;
use App\Models\CommisionDetail;
use App\Models\InsuranceCommisioner;
use App\Models\CollectionDetail;
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


    // public function showInsuranceDetailss($id)
    // {
    //     $user = Auth::user();
    //     $role = $user->role;

    //     $permissions = RolePermission::where('role_id', $role->id)
    //         ->where('can_view', 1)
    //         ->get();

    //     if ($permissions->isEmpty()) {
    //         return response()->json(['message' => 'No permissions found'], 403);
    //     }

    //     $data = [];
    //     $tables = [
    //         'assured_details',
    //         'insurance_details',
    //         'payment_details',
    //         'commision_details',
    //         'insurance_commisioners',
    //         'collection_details'
    //     ];

    //     foreach ($tables as $tableName) {
    //         $allowedColumns = $permissions->where('table_name', $tableName)
    //             ->pluck('column_name')
    //             ->toArray();

    //         if (count($allowedColumns) > 0) {
    //             if ($tableName == 'insurance_details') {
    //                 try {
    //                     $query = InsuranceDetail::with([
    //                         'assured.assuredDetail',
    //                         'salesAssociate',
    //                         'branchManager',
    //                         'product',
    //                         'subproduct',
    //                         'source',
    //                         'sourceBranch',
    //                         'ifGdfi',
    //                         'area',
    //                         'alfcBranch',
    //                         'modeOfPayment',
    //                         'provider',
    //                     ])->where('insurance_details.id', $id);

    //                     $columnsWithPrefix = array_map(function ($column) use ($tableName) {
    //                         return "{$tableName}.{$column}";
    //                     }, $allowedColumns);

    //                     $records = $query->select($columnsWithPrefix)->first();

    //                     if ($records) {
    //                         // Define an array of field mappings for replacement
    //                         $fieldsToReplace = [
    //                             'assured_id' => 'assured',
    //                             'sales_associate_id' => 'salesAssociate',
    //                             'branch_manager_id' => 'branchManager',
    //                             'product_id' => 'product',
    //                             'subproduct_id' => 'subproduct',
    //                             'source_id' => 'source',
    //                             'source_branch_id' => 'sourceBranch',
    //                             'if_gdfi_id' => 'ifGdfi',
    //                             'area_id' => 'area',
    //                             'alfc_branch_id' => 'alfcBranch',
    //                             'mode_of_payment_id' => 'modeOfPayment',
    //                             'provider_id' => 'provider',
    //                         ];

    //                         // Convert the object to an array using toArray() to get only the model attributes
    //                         $recordsArray = $records->toArray();  // Using toArray() method

    //                         // Create a new array to hold the modified records
    //                         $newRecordsArray = [];

    //                         // Iterate through the original record fields
    //                         foreach ($recordsArray as $key => $value) {
    //                             // If the field is in the replacement map, replace it
    //                             if (isset($fieldsToReplace[$key])) {
    //                                 // Replace _id with _name and get the corresponding name
    //                                 $relation = $fieldsToReplace[$key];
    //                                 if ($key === 'assured_id') {
    //                                     // Special case for assured_id to become assured_name
    //                                     $newRecordsArray['assured_name'] = optional($records->{$relation})->name ?? "***";
    //                                 } else {
    //                                     // For all other fields, just remove the _id suffix and replace it with related name
    //                                     $newKey = str_replace('_id', '', $key);  // Remove _id from the key
    //                                     $newRecordsArray[$newKey . '_name'] = optional($records->{$relation})->name ?? "***";
    //                                 }
    //                             } else {
    //                                 // If the field value is null, show '***'
    //                                 $newRecordsArray[$key] = $value ?? "***";
    //                             }
    //                         }

    //                         // Convert back to object
    //                         $records = (object) $newRecordsArray;

    //                         // Store the modified records in the $data array
    //                         $data[$tableName] = $records;
    //                     } else {
    //                         $data[$tableName] = null;
    //                     }
    //                 } catch (\Exception $e) {
    //                     Log::error("Error processing insurance_details: " . $e->getMessage());
    //                     $data[$tableName] = null;
    //                 }
    //             } elseif ($tableName == 'assured_details') {
    //                 try {
    //                     $query = AssuredDetail::whereHas('assured.insuranceDetails', function ($q) use ($id) {
    //                         $q->where('insurance_details.id', $id);
    //                     });

    //                     $assuredName = InsuranceDetail::with('assured')
    //                         ->where('insurance_details.id', $id)
    //                         ->first()
    //                         ->assured
    //                         ->name;

    //                     $columnsWithPrefix = array_map(function ($column) use ($tableName) {
    //                         return "{$tableName}.{$column}";
    //                     }, $allowedColumns);

    //                     $records = $query->select($columnsWithPrefix)->first();

    //                     if ($records) {
    //                         $records->assured_name = $assuredName;

    //                         $recordWithAssuredNameFirst = new \stdClass();
    //                         $recordWithAssuredNameFirst->assured_name = $assuredName;

    //                         foreach ($records->getAttributes() as $key => $value) {
    //                             // If the field value is empty or null, set it to '***'
    //                             $recordWithAssuredNameFirst->$key = (empty($value)) ? "***" : $value;
    //                         }

    //                         $data[$tableName] = $recordWithAssuredNameFirst;
    //                     } else {
    //                         $data[$tableName] = null;
    //                     }
    //                 } catch (\Exception $e) {
    //                     Log::error("Error processing assured_details: " . $e->getMessage());
    //                     $data[$tableName] = null;
    //                 }
    //             } elseif ($tableName == 'payment_details') {
    //                 try {
    //                     $query = PaymentDetail::where('insurance_detail_id', $id);

    //                     $columnsWithPrefix = array_map(function ($column) use ($tableName) {
    //                         return "{$tableName}.{$column}";
    //                     }, $allowedColumns);

    //                     $records = $query->select($columnsWithPrefix)->first();

    //                     if ($records) {
    //                         // Iterate over each record's attributes
    //                         foreach ($records->getAttributes() as $key => $value) {
    //                             // If the field value is empty or null, set it to '***'
    //                             $records->$key = (empty($value)) ? "***" : $value;
    //                         }
    //                         $data[$tableName] = $records;
    //                     } else {
    //                         $data[$tableName] = null;
    //                     }
    //                 } catch (\Exception $e) {
    //                     Log::error("Error processing payment_details: " . $e->getMessage());
    //                     $data[$tableName] = null;
    //                 }
    //             } elseif ($tableName == 'commision_details') {
    //                 try {
    //                     $query = CommisionDetail::where('insurance_detail_id', $id);

    //                     $columnsWithPrefix = array_map(function ($column) use ($tableName) {
    //                         return "{$tableName}.{$column}";
    //                     }, $allowedColumns);

    //                     $records = $query->select($columnsWithPrefix)->first();

    //                     if ($records) {
    //                         // Iterate over each record's attributes
    //                         foreach ($records->getAttributes() as $key => $value) {
    //                             // If the field value is empty or null, set it to '***'
    //                             $records->$key = (empty($value)) ? "***" : $value;
    //                         }
    //                         $data[$tableName] = $records;
    //                     } else {
    //                         $data[$tableName] = null;
    //                     }
    //                 } catch (\Exception $e) {
    //                     Log::error("Error processing commision_details: " . $e->getMessage());
    //                     $data[$tableName] = null;
    //                 }
    //             } elseif ($tableName == 'insurance_commisioners') {
    //                 Log::info("Processing table: $tableName");

    //                 try {
    //                     // Query InsuranceCommissioner for the given insurance_detail_id
    //                     $query = InsuranceCommisioner::with('commisioner') // Eager load the commisioner relationship
    //                         ->where('insurance_detail_id', $id);

    //                     // Prefix the columns in the insurance_commissioners table
    //                     $columnsWithPrefix = array_map(function ($column) use ($tableName) {
    //                         return "{$tableName}.{$column}";
    //                     }, $allowedColumns);

    //                     // Log::info("Columns selected: ", $columnsWithPrefix);

    //                     // Retrieve the records without the join, using the relationship to get commisioner_name
    //                     $records = $query
    //                         ->select($columnsWithPrefix) // Select the necessary columns from insurance_commissioners table
    //                         ->get();

    //                     // Check if there are any records
    //                     if ($records->isNotEmpty()) {
    //                         // Initialize an empty array to store each record's data
    //                         $data[$tableName] = [];

    //                         // Iterate over each record and store the details
    //                         foreach ($records as $record) {
    //                             $data[$tableName][] = [
    //                                 'commisioner_name' => optional($record->commisioner)->name ?? "***", // Access commisioner name via the relationship
    //                                 'amount' => $record->amount ?? "***",
    //                             ];
    //                         }

    //                         // Log::info("Data formatted for table: $tableName", $data[$tableName]);
    //                     } else {
    //                         $data[$tableName] = null;
    //                         // Log::info("No records found for insurance_detail_id: $id");
    //                     }
    //                 } catch (\Exception $e) {
    //                     Log::error("Error processing table: $tableName", ['error' => $e->getMessage()]);
    //                     $data[$tableName] = null;
    //                 }
    //             } elseif ($tableName == 'collection_details') {
    //                 try {
    //                     // Query CollectionDetail for the given insurance_detail_id with the Tele relationship
    //                     $query = CollectionDetail::with('tele') // Eager load the 'tele' relationship
    //                         ->where('insurance_detail_id', $id);

    //                     // Prefix the columns in the collection_details table
    //                     $columnsWithPrefix = array_map(function ($column) use ($tableName) {
    //                         return "{$tableName}.{$column}";
    //                     }, $allowedColumns);

    //                     // Retrieve the first record from collection_details
    //                     $records = $query->select($columnsWithPrefix)->first();

    //                     if ($records) {
    //                         // Define an array to store modified records
    //                         $newRecordsArray = [];

    //                         // Iterate over each record's attributes
    //                         foreach ($records->getAttributes() as $key => $value) {
    //                             // Check if the field is related to a model (e.g., tele relationship) and replace with '_name'
    //                             if ($key === 'tele_id') {
    //                                 // Special case for tele relationship, assign tele_name
    //                                 $newRecordsArray['tele_name'] = optional($records->tele)->name ?? "***";
    //                             } else {
    //                                 // If the field value is empty or null, set it to '***'
    //                                 $newRecordsArray[$key] = (empty($value)) ? "***" : $value;
    //                             }
    //                         }

    //                         // Convert the array back to an object
    //                         $records = (object) $newRecordsArray;

    //                         // Store the modified records in the $data array
    //                         $data[$tableName] = $records;
    //                     } else {
    //                         $data[$tableName] = null;
    //                     }
    //                 } catch (\Exception $e) {
    //                     Log::error("Error processing collection_details: " . $e->getMessage());
    //                     $data[$tableName] = null;
    //                 }
    //             } else {
    //                 Log::info("No allowed columns for table: {$tableName}");
    //             }
    //         }

    //     }
    //     return response()->json($data);
    // }

    public function showInsuranceDetails($id)
    {
        $user = Auth::user();
        $role = $user->role;

        // Check if the role has the permission to view
        $permissions = RolePermission::where('role_id', $role->id)->get();

        if ($permissions->isEmpty()) {
            return response()->json(['message' => 'No permissions found'], 403);
        }

        $data = [];
        $tables = [
            'assured_details',
            'insurance_details',
            'commision_details',
            'insurance_commisioners',
            'collection_details',
            'payment_details',
        ];

        $insuranceDetail = InsuranceDetail::with([
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
            'paymentDetail',
            'commisionDetail',
            'collectionDetail.tele',
            'insuranceCommisioner.commisioner'
        ])
        ->where('insurance_details.id', $id)
        ->first();

        if (!$insuranceDetail) {
            return response()->json(['message' => 'Insurance details not found'], 404);
        }

        foreach ($tables as $tableName) {
            $tablePermissions = $permissions->where('table_name', $tableName)->where('can_view', 1);
        
            if ($tablePermissions->count() > 0) {
                $data[$tableName] = $this->getTableData($tableName, $insuranceDetail, $permissions);
            }
        }

        return response()->json($data, 200);
    }

    private function getTableData($tableName, $insuranceDetail, $permissions)
    {
        // Set default data
        $tableData = $this->getDefaultTableData($tableName, $insuranceDetail);

        // Apply permission-based masking
        foreach ($permissions as $permission) {
            if ($permission->table_name == $tableName) {
                foreach ($tableData as $key => $value) {
                    if ($permission->can_view == 0 && $permission->column_name == $key) {
                        $tableData[$key] = '*****';
                    }
                }
            }
        }

        return $tableData;
    }

    private function getDefaultTableData($tableName, $insuranceDetail)
    {
        switch ($tableName) {
            case 'assured_details':
                return [
                    'assured_name' => $insuranceDetail->assured->name ?? "N/A",
                    'address' => $insuranceDetail->assured->assuredDetail->address ?? "N/A",
                    'contact_number' => $insuranceDetail->assured->assuredDetail->contact_number ?? "N/A",
                    'other_contact_number' => $insuranceDetail->assured->assuredDetail->other_contact_number ?? "N/A",
                    'email' => $insuranceDetail->assured->assuredDetail->email ?? "N/A",
                    'facebook_account' => $insuranceDetail->assured->assuredDetail->facebook_account ?? "N/A",
                    'viber_account' => $insuranceDetail->assured->assuredDetail->viber_account ?? "N/A",
                    'nature_of_business' => $insuranceDetail->assured->assuredDetail->nature_of_business ?? "N/A",
                    'other_assets' => $insuranceDetail->assured->assuredDetail->other_assets ?? "N/A",
                    'remarks' => $insuranceDetail->assured->assuredDetail->remarks ?? "N/A",
                ];
            case 'insurance_details':
                return [
                    'issuance_code' => $insuranceDetail->issuance_code ?? "N/A",
                    'assured_name' => $insuranceDetail->assured->name ?? "N/A",
                    'sales_associate_name' => $insuranceDetail->salesAssociate->name ?? "N/A",
                    'sale_date' => $insuranceDetail->sale_date ?? "N/A",
                    'classification' => $insuranceDetail->classification ?? "N/A",
                    'insurance_type' => $insuranceDetail->insurance_type ?? "N/A",
                    'sale_status' => $insuranceDetail->sale_status ?? "N/A",
                    'branch_manager_name' => $insuranceDetail->branchManager->name ?? "N/A",
                    'legal_representative_name' => $insuranceDetail->legal_representative_name ?? "N/A",
                    'legal_supervisor_name' => $insuranceDetail->legal_supervisor_name ?? "N/A",
                    'assigned_atty_one' => $insuranceDetail->assigned_atty_one ?? "N/A",
                    'assigned_atty_two' => $insuranceDetail->assigned_atty_two ?? "N/A",
                    'collection_gm' => $insuranceDetail->collection_gm ?? "N/A",
                    'product_name' => $insuranceDetail->product->name ?? "N/A",
                    'subproduct_name' => $insuranceDetail->subproduct->name ?? "N/A",
                    'source_name' => $insuranceDetail->source->name ?? "N/A",
                    'source_branch_name' => $insuranceDetail->sourceBranch->name ?? "N/A",
                    'if_gdfi_name' => $insuranceDetail->ifGdfi->name ?? "N/A",
                    'mortgagee' => $insuranceDetail->mortgagee ?? "N/A",
                    'area_name' => $insuranceDetail->area->name ?? "N/A",
                    'alfc_branch_name' => $insuranceDetail->alfcBranch->name ?? "N/A",
                    'loan_amount' => $insuranceDetail->loan_amount ?? "N/A",
                    'total_sum_insured' => $insuranceDetail->total_sum_insured ?? "N/A",
                    'policy_number' => $insuranceDetail->policy_number ?? "N/A",
                    'policy_inception_date' => $insuranceDetail->policy_inception_date ?? "N/A",
                    'expiry_date' => $insuranceDetail->expiry_date ?? "N/A",
                    'plate_conduction_number' => $insuranceDetail->plate_conduction_number ?? "N/A",
                    'description' => $insuranceDetail->description ?? "N/A",
                    'policy_expiration_aging' => $insuranceDetail->policy_expiration_aging ?? "N/A",
                    'book_number' => $insuranceDetail->book_number ?? "N/A",
                    'filing_number' => $insuranceDetail->filing_number ?? "N/A",
                    'pid_received_date' => $insuranceDetail->pid_received_date ?? "N/A",
                    'pid_completion_date' => $insuranceDetail->pid_completion_date ?? "N/A",
                    'remarks' => $insuranceDetail->remarks ?? "N/A",
                    'mode_of_payment_name' => $insuranceDetail->modeOfPayment->name ?? "N/A",
                    'provider_name' => $insuranceDetail->provider->name ?? "N/A",
                ];
            case 'commision_details':
                return [
                    'provision_receipt' => $insuranceDetail->commisionDetail->provision_receipt ?? "N/A",
                    'gross_premium' => $insuranceDetail->commisionDetail->gross_premium ?? "N/A",
                    'discount' => $insuranceDetail->commisionDetail->discount ?? "N/A",
                    'net_discounted' => $insuranceDetail->commisionDetail->net_discounted ?? "N/A",
                    'amount_due_to_provider' => $insuranceDetail->commisionDetail->amount_due_to_provider ?? "N/A",
                    'full_commission' => $insuranceDetail->commisionDetail->full_commission ?? "N/A",
                    'marketing_fund' => $insuranceDetail->commisionDetail->marketing_fund ?? "N/A",
                    'offsetting' => $insuranceDetail->commisionDetail->offsetting ?? "N/A",
                    'promo' => $insuranceDetail->commisionDetail->promo ?? "N/A",
                    'total_commission' => $insuranceDetail->commisionDetail->total_commission ?? "N/A",
                    'vat' => $insuranceDetail->commisionDetail->vat ?? "N/A",
                    'sales_credit' => $insuranceDetail->commisionDetail->sales_credit ?? "N/A",
                    'sales_credit_percent' => $insuranceDetail->commisionDetail->sales_credit_percent ?? "N/A",
                    'comm_deduct' => $insuranceDetail->commisionDetail->comm_deduct ?? "N/A"
                ];
            case 'insurance_commisioners':
                $commissionersData = [];
                foreach ($insuranceDetail->insuranceCommisioner as $commisionerDetail) {
                    $commissionersData[] = [
                        'commisioner_name' => $commisionerDetail->commisioner->name ?? "N/A",
                        'amount' => $commisionerDetail->amount ?? "N/A"
                    ];
                }
                return $commissionersData;
            case 'collection_details':
                return [
                    'insurance_type' => $insuranceDetail->collectionDetail->insurance_type ?? "N/A",
                    'sale_status' => $insuranceDetail->collectionDetail->sale_status ?? "N/A",
                    'tele_name' => $insuranceDetail->collectionDetail->tele->name ?? "N/A",
                    'due_date' => $insuranceDetail->collectionDetail->due_date ?? "N/A",
                    'paid_terms' => $insuranceDetail->collectionDetail->paid_terms ?? "N/A",
                    'payment_remarks' => $insuranceDetail->collectionDetail->payment_remarks ?? "N/A",
                    'account_status' => $insuranceDetail->collectionDetail->account_status ?? "N/A",
                    'payment_ptp_declared' => $insuranceDetail->collectionDetail->payment_ptp_declared ?? "N/A",
                    'payment_center' => $insuranceDetail->collectionDetail->payment_center ?? "N/A",
                    'reference_number' => $insuranceDetail->collectionDetail->reference_number ?? "N/A",
                    'date_on_receipt_abstract' => $insuranceDetail->collectionDetail->date_on_receipt_abstract ?? "N/A",
                    'contact_number_verification' => $insuranceDetail->collectionDetail->contact_number_verification ?? "N/A"
                ];
            case 'payment_details':
                return [
                    'payment_terms' => $insuranceDetail->paymentDetail->payment_terms ?? "N/A",
                    'due_date' => $insuranceDetail->paymentDetail->due_date ?? "N/A",
                    'schedule_first_payment' => $insuranceDetail->paymentDetail->schedule_first_payment ?? "N/A",
                    'schedule_second_payment' => $insuranceDetail->paymentDetail->schedule_second_payment ?? "N/A",
                    'schedule_third_payment' => $insuranceDetail->paymentDetail->schedule_third_payment ?? "N/A",
                    'schedule_fourth_payment' => $insuranceDetail->paymentDetail->schedule_fourth_payment ?? "N/A",
                    'schedule_fifth_payment' => $insuranceDetail->paymentDetail->schedule_fifth_payment ?? "N/A",
                    'schedule_sixth_payment' => $insuranceDetail->paymentDetail->schedule_sixth_payment ?? "N/A",
                    'schedule_seventh_payment' => $insuranceDetail->paymentDetail->schedule_seventh_payment ?? "N/A",
                    'schedule_eighth_payment' => $insuranceDetail->paymentDetail->schedule_eighth_payment ?? "N/A",
                    'for_billing' => $insuranceDetail->paymentDetail->for_billing ?? "N/A",
                    'over_under_payment' => $insuranceDetail->paymentDetail->over_under_payment ?? "N/A",
                    'initial_payment' => $insuranceDetail->paymentDetail->initial_payment ?? "N/A",
                    'good_as_sales_date' => $insuranceDetail->paymentDetail->good_as_sales_date ?? "N/A",
                    'status' => $insuranceDetail->paymentDetail->status ?? "N/A",
                    'ra_comments' => $insuranceDetail->paymentDetail->ra_comments ?? "N/A",
                    'admin_assistant_remarks' => $insuranceDetail->paymentDetail->admin_assistant_remarks ?? "N/A",
                    'tracking_number' => $insuranceDetail->paymentDetail->tracking_number ?? "N/A",
                    'policy_received_by' => $insuranceDetail->paymentDetail->policy_received_by ?? "N/A"
                ];
            default:
                return [];
        }
    }



}





