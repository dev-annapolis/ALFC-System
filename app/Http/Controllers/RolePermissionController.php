<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\RolePermission;

class RolePermissionController extends Controller
{
    public function edit()
    {
        $roles = Role::all();

        // Example table structure
        $tables = [
            'insurance' => ['assured_id', 'sales_associate_id'],
            // Add other tables and columns as needed
        ];

        return view('permissions.edit', compact('roles', 'tables'));
    }

    public function update(Request $request)
    {
        $roles = Role::all();
        $tables = [
            'insurance' => ['assured_id', 'sales_associate_id'],
            // Add other tables and columns as needed
        ];

        foreach ($roles as $role) {
            foreach ($tables as $table => $columns) {
                foreach ($columns as $column) {
                    // Check if 'view' and 'edit' permissions exist for this role, table, and column
                    $canView = isset($request->permissions[$role->id][$table][$column]['view']);
                    $canEdit = isset($request->permissions[$role->id][$table][$column]['edit']);

                    // Update or create the permission record
                    RolePermission::updateOrCreate(
                        [
                            'role_id' => $role->id,
                            'table_name' => $table,
                            'column_name' => $column
                        ],
                        [
                            'can_view' => $canView,
                            'can_edit' => $canEdit,
                        ]
                    );
                }
            }
        }

        return redirect()->route('permissions.edit')->with('success', 'Permissions updated successfully.');
    }


}
