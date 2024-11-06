@extends('layouts.app')

@section('content')
    <h2>Universal Data Table</h2>

    @foreach($data as $tableName => $records)
        <h3>{{ ucfirst($tableName) }} Records</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    @foreach($permissions->where('table_name', $tableName)->pluck('column_name') as $column)
                        <th>{{ ucfirst($column) }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($records as $record)
                    <tr>
                        @foreach($permissions->where('table_name', $tableName)->pluck('column_name') as $column)
                            <td>{{ $record->$column }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
@endsection
