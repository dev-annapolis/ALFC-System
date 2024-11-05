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
                    <th>Role</th>
                    @foreach($tables as $table => $columns)
                        <th colspan="{{ count($columns) * 2 }}">{{ ucfirst($table) }}</th>
                    @endforeach
                </tr>
                <tr>
                    <td></td>
                    @foreach($tables as $columns)
                        @foreach($columns as $column)
                            <th colspan="2">{{ $column}}</th>
                        @endforeach
                    @endforeach
                </tr>
                <tr>
                    <td></td>
                    @foreach($tables as $columns)
                        @foreach($columns as $column)
                            <th>View</th>
                            <th>Edit</th>
                        @endforeach
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $role)
                    <tr>
                        <td>{{ $role->name }}</td>
                        @foreach($tables as $table => $columns)
                            @foreach($columns as $column)
                                <td>
                                    <input type="checkbox" name="permissions[{{ $role->id }}][{{ $table }}][{{ $column }}][view]"
                                           {{ $role->permissions->where('table_name', $table)->where('column_name', $column)->where('can_view', true)->isNotEmpty() ? 'checked' : '' }}>
                                </td>
                                <td>
                                    <input type="checkbox" name="permissions[{{ $role->id }}][{{ $table }}][{{ $column }}][edit]"
                                           {{ $role->permissions->where('table_name', $table)->where('column_name', $column)->where('can_edit', true)->isNotEmpty() ? 'checked' : '' }}>
                                </td>
                            @endforeach
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Save Permissions</button>
    </form>
@endsection
