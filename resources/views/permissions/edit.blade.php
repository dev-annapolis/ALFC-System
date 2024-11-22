@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="text-center mb-4">Manage Permissions</h2>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <form action="{{ route('permissions.update') }}" method="POST">
        @csrf
        <ul class="nav nav-tabs" id="permissionTabs" role="tablist">
            @foreach($tables as $table => $columns)
                <li class="nav-item" role="presentation">
                    <button 
                        class="nav-link {{ $loop->first ? 'active' : '' }}" 
                        id="tab-{{ $table }}" 
                        data-bs-toggle="tab" 
                        data-bs-target="#content-{{ $table }}" 
                        type="button" 
                        role="tab" 
                        aria-controls="content-{{ $table }}" 
                        aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                        {{ ucwords(str_replace('_', ' ', $table)) }}
                    </button>
                </li>
            @endforeach
        </ul>

        <div class="tab-content mt-3" id="permissionTabsContent">
            @foreach($tables as $table => $columns)
                <div 
                    class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" 
                    id="content-{{ $table }}" 
                    role="tabpanel" 
                    aria-labelledby="tab-{{ $table }}">
                    
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-primary text-center">
                                <tr>
                                    <th>Column</th>
                                    
                                    @foreach($roles as $role)
                                        <th colspan="2">{{ ucwords(str_replace('_', ' ', $role->name)) }}</th>
                                    @endforeach

                                </tr>
                                <tr>
                                    <th>
                                        Check All<br>
                                        <input type="checkbox" class="form-check-input check-all-table" data-table="{{ $table }}" title="Check All for this table">
                                    </th>
                                    
                                    @foreach($roles as $role)
                                        <th>
                                            View<br>
                                            <input type="checkbox" class="form-check-input check-all" data-type="view" data-role="{{ $role->id }}" data-table="{{ $table }}">
                                        </th>
                                        <th>
                                            Edit<br>
                                            <input type="checkbox" class="form-check-input check-all" data-type="edit" data-role="{{ $role->id }}" data-table="{{ $table }}">
                                        </th>
                                    @endforeach
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($columns as $column)
                                    <tr>
                                        <td>{{ ucwords(str_replace('_', ' ', $column)) }}</td>
                                        @foreach($roles as $role)
                                            <td class="text-center">
                                                <input type="checkbox" 
                                                       class="form-check-input checkbox-view checkbox-role-{{ $role->id }} checkbox-table-{{ $table }}" 
                                                       name="permissions[{{ $role->id }}][{{ $table }}][{{ $column }}][view]"
                                                       {{ $role->rolePermissions->where('table_name', $table)->where('column_name', $column)->where('can_view', true)->isNotEmpty() ? 'checked' : '' }}>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" 
                                                       class="form-check-input checkbox-edit checkbox-role-{{ $role->id }} checkbox-table-{{ $table }}" 
                                                       name="permissions[{{ $role->id }}][{{ $table }}][{{ $column }}][edit]"
                                                       {{ $role->rolePermissions->where('table_name', $table)->where('column_name', $column)->where('can_edit', true)->isNotEmpty() ? 'checked' : '' }}>
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary">Save Permissions</button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Handle "Check All" for each role (view/edit)
        document.querySelectorAll('.check-all').forEach(checkAllBox => {
            checkAllBox.addEventListener('change', function () {
                const role = this.getAttribute('data-role');
                const type = this.getAttribute('data-type');
                const table = this.getAttribute('data-table');
                const checkboxes = document.querySelectorAll(`.checkbox-${type}.checkbox-role-${role}.checkbox-table-${table}`);
                
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });
        });

        // Handle "Check All" for the entire table
        document.querySelectorAll('.check-all-table').forEach(checkAllTableBox => {
            checkAllTableBox.addEventListener('change', function () {
                const table = this.getAttribute('data-table');
                const checkboxes = document.querySelectorAll(`.checkbox-table-${table}`);
                
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });

                // Also check/uncheck individual role-type check-all for the table
                const tableRoleCheckAllBoxes = document.querySelectorAll(`.check-all[data-table="${table}"]`);
                tableRoleCheckAllBoxes.forEach(roleCheckAll => {
                    roleCheckAll.checked = this.checked;
                });
            });
        });
    });
</script>
@endsection
