@extends('layouts.app')  <!-- Assuming you're using a layout -->

@section('content')
    <div class="container">
        <h1>Records</h1>

        <!-- Loop through each table's records -->
        @foreach($data as $tableName => $records)
            <h2>{{ ucwords(str_replace('_', ' ', $tableName)) }}</h2> <!-- Table name in a human-readable format -->

            <!-- Only display table if there are records -->
            @if($records->isNotEmpty())
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <!-- Dynamically generate headers based on the columns for this table -->
                            @foreach($permissions->where('table_name', $tableName) as $permission)
                                <th>{{ ucwords(str_replace('_', ' ', $permission->column_name)) }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Loop through each record and display the allowed columns -->
                        @foreach($records as $record)
                            <tr>
                                @foreach($permissions->where('table_name', $tableName) as $permission)
                                    <!-- Dynamically display only the columns the user has access to -->
                                    <td>{{ $record->{$permission->column_name} }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No records available for this table.</p>
            @endif
        @endforeach
    </div>
@endsection
