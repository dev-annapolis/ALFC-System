@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="text-center mb-4">Manage Permissions</h2>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <form action="{{ route('permissions.update') }}" method="POST">
        @csrf
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-primary text-center">
                    <tr>
                        <th>Table / Column</th>
                        @foreach($roles as $role)
                            <th colspan="2">{{ ucwords(str_replace('_', ' ', $role->name)) }}</th>
                        @endforeach
                    </tr>
                    <tr>
                        <td></td>
                        @foreach($roles as $role)
                            <th>
                                View<br>
                                <input type="checkbox" class="form-check-input check-all" data-type="view" data-role="{{ $role->id }}">
                            </th>
                            <th>
                                Edit<br>
                                <input type="checkbox" class="form-check-input check-all" data-type="edit" data-role="{{ $role->id }}">
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($tables as $table => $columns)
                        <tr class="table-secondary">
                            <td colspan="{{ count($roles) * 2 + 1 }}" class="fw-bold">{{ ucwords(str_replace('_', ' ', $table)) }}</td>
                        </tr>
                        @foreach($columns as $column)
                            <tr>
                                <td>{{ ucwords(str_replace('_', ' ', $column)) }}</td>
                                @foreach($roles as $role)
                                    <td class="text-center">
                                        <input type="checkbox" 
                                               class="form-check-input checkbox-view checkbox-role-{{ $role->id }}" 
                                               name="permissions[{{ $role->id }}][{{ $table }}][{{ $column }}][view]"
                                               {{ $role->rolePermissions->where('table_name', $table)->where('column_name', $column)->where('can_view', true)->isNotEmpty() ? 'checked' : '' }}>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" 
                                               class="form-check-input checkbox-edit checkbox-role-{{ $role->id }}" 
                                               name="permissions[{{ $role->id }}][{{ $table }}][{{ $column }}][edit]"
                                               {{ $role->rolePermissions->where('table_name', $table)->where('column_name', $column)->where('can_edit', true)->isNotEmpty() ? 'checked' : '' }}>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary">Save Permissions</button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const checkAllBoxes = document.querySelectorAll('.check-all');
        
        checkAllBoxes.forEach(checkAllBox => {
            checkAllBox.addEventListener('change', function () {
                const role = this.getAttribute('data-role');
                const type = this.getAttribute('data-type');
                const checkboxes = document.querySelectorAll(`.checkbox-${type}.checkbox-role-${role}`);
                
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });
        });
    });
</script>
@endsection
