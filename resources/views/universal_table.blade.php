@extends('layouts.app')

@section('content')
    <h2>Universal Data Table</h2>

    <!-- Single Table for All Data -->
    <div class="row">
        <div class="col gx-0">
            <!-- Table Structure for All Data -->
            <table class="table table-bordered">
                <thead>
                    <!-- Table Names Row (Side by Side) -->
                    <tr>
                        @foreach($data as $tableName => $records)
                            @php
                                $viewableColumns = $permissions->where('table_name', $tableName)->where('can_view', 1)->pluck('column_name');
                            @endphp

                            <!-- Only show table name if there are viewable columns -->
                            @if ($viewableColumns->count() > 0)
                                <th colspan="{{ $viewableColumns->count() }}" class="text-center">
                                    <h4>{{ ucwords(str_replace('_', ' ', $tableName)) }}</h4>
                                </th>
                            @endif
                        @endforeach
                        <!-- Add the Action column header -->
                        <th class="text-center"></th>
                    </tr>

                    <!-- Column Headers Row (Aligned to Table Names) -->
                    <tr>
                        @foreach($data as $tableName => $records)
                            @php
                                $viewableColumns = $permissions->where('table_name', $tableName)->where('can_view', 1)->pluck('column_name');
                            @endphp

                            <!-- Only show columns if they are viewable -->
                            @foreach($viewableColumns as $column)
                                <th>{{ ucwords(str_replace('_', ' ', $column)) }}</th>
                            @endforeach
                        @endforeach
                        <!-- Add the Actions column header -->
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <!-- Data Rows (Side by Side for Each Table) -->
                    @foreach($records as $record)
                        <tr>
                            @foreach($data as $tableName => $records)
                                @php
                                    $viewableColumns = $permissions->where('table_name', $tableName)->where('can_view', 1)->pluck('column_name');
                                @endphp

                                <!-- Only show data for tables with viewable columns -->
                                @foreach($viewableColumns as $column)
                                    <td>{{ $record->$column ?? 'N/A' }}</td> <!-- Display Record Data -->
                                @endforeach
                            @endforeach
                            <!-- Add Action column with buttons (e.g., Edit, Delete) -->
                            <td class="text-center">
                                <a href="{{ route('edit.route', ['id' => $record->id]) }}" class="btn btn-primary btn-sm">Edit</a>
                                <a href="{{ route('delete.route', ['id' => $record->id]) }}" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
