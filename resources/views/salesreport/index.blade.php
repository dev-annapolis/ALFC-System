@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Sales Report</h2>
    <table id="salesReportTable" class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Contact Number</th>
                <th>Email</th>
                <th>Issuance Code</th>
                <th>Sale Date</th>
                <th>Good As Sales Date</th>
                <th>Sales Associate</th>
                <th>Sales Team</th>
                <th>Branch Manager</th>
                <th>Source</th>
                <th>Subproduct</th>
                <th>Policy Inception Date</th>
                <th>Provider</th>
                <th>Sale Status</th>
            </tr>
        </thead>
        <tbody>
            <!-- Table rows will be dynamically inserted here -->
        </tbody>
    </table>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Trigger the AJAX request when the page loads
    $(document).ready(function() {
        $.ajax({
            url: '/api/sales-report',  // API endpoint to fetch sales report data
            method: 'GET',
            success: function(data) {
                var tableBody = $('#salesReportTable tbody');
                tableBody.empty();  // Clear existing table rows

                // Loop through each item in the returned data
                data.forEach(function(detail) {
                    var row = `<tr>
                        <td>${detail.name}</td>
                        <td>${detail.contact_number}</td>
                        <td>${detail.email}</td>
                        <td>${detail.issuance_code}</td>
                        <td>${detail.sale_date}</td>
                        <td>${detail.good_as_sales_date}</td>
                        <td>${detail.sales_associate}</td>
                        <td>${detail.sales_team}</td>
                        <td>${detail.branch_manager}</td>
                        <td>${detail.source}</td>
                        <td>${detail.subproduct}</td>
                        <td>${detail.policy_inception_date}</td>
                        <td>${detail.provider}</td>
                        <td>${detail.sale_status}</td>
                    </tr>`;
                    tableBody.append(row);  // Append row to the table body
                });
            },
            error: function(xhr, status, error) {
                alert("Error loading sales report data: " + error);
            }
        });
    });
</script>
@endsection