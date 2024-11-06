@extends('layouts.app')

@section('content')
    <h2>Manage Permissions</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('permissions.update') }}" method="POST">
        @csrf
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Table / Column</th>
                    @foreach($roles as $role)
                        <th colspan="2">{{ $role->name }}</th>
                    @endforeach
                </tr>
                <tr>
                    <td></td>
                    @foreach($roles as $role)
                        <th>View</th>
                        <th>Edit</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($tables as $table => $columns)
                    <tr>
                        <td colspan="{{ count($roles) * 2 }}">{{ ucfirst($table) }}</td>
                    </tr>
                    @foreach($columns as $column)
                        <tr>
                            <td>{{ $column }}</td>
                            @foreach($roles as $role)
                                <td>
                                    <input type="checkbox" name="permissions[{{ $role->id }}][{{ $table }}][{{ $column }}][view]"
                                           {{ $role->permissions->where('table_name', $table)->where('column_name', $column)->where('can_view', true)->isNotEmpty() ? 'checked' : '' }}>
                                </td>
                                <td>
                                    <input type="checkbox" name="permissions[{{ $role->id }}][{{ $table }}][{{ $column }}][edit]"
                                           {{ $role->permissions->where('table_name', $table)->where('column_name', $column)->where('can_edit', true)->isNotEmpty() ? 'checked' : '' }}>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Save Permissions</button>
    </form>
@endsection
