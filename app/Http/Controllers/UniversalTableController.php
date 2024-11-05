<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UniversalTableController extends Controller
{
    public function showRecords()
    {
        $user = auth()->user();
        $role = $user->role;

        // Get permissions for the current user's role
        $permissions = RolePermission::where('role_id', $role->id)
            ->where('permission_type', 'view')
            ->get();

        // Initialize data array to hold records for each table
        $data = [];
        $tables = ['insurance', 'commission', 'payments']; // List all relevant tables

        foreach ($tables as $table) {
            $allowedColumns = $permissions->where('table_name', $table)->pluck('column_name')->toArray();

            if (!empty($allowedColumns)) {
                $data[$table] = DB::table($table)->select($allowedColumns)->get();
            }
        }

        return view('universal_table', compact('data', 'permissions'));
    }
}
