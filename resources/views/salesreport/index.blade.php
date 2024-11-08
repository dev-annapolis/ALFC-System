@extends('layouts.app')

@section('content')
<style>
      
      @media (min-width: 992px) { /* For large screens */
        .custom-offcanvas {
            width: 35% !important; /* Make it 70% width on large screens */
        }
    }

    @media (max-width: 991px) { /* For smaller screens */
        .custom-offcanvas {
            width: 100% !important; /* Full width on smaller screens */
        }
    }
</style>
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
                <th>Actions</th> <!-- Added Actions column -->
            </tr>
        </thead>
        <tbody>
            <!-- Table rows will be dynamically inserted here -->
        </tbody>
    </table>
</div>

<div class="custom-offcanvas offcanvas offcanvas-end" tabindex="-1" id="detailOffCanvas" aria-labelledby="detailOffCanvasLabel" data-bs-backdrop="false">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="detailOffCanvasLabel">Insurance Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <!-- Nav tabs for tables -->
        <ul class="nav nav-tabs" id="insuranceTabs" role="tablist">
            <!-- Tabs will be dynamically inserted here -->
        </ul>

        <!-- Tab content area -->
        <div class="tab-content mt-3" id="insuranceTabContent">
            <!-- Tab panes will be dynamically inserted here -->
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
  $(document).ready(function() {
    // Load the sales report data when the page loads
    $.ajax({
        url: '/api/sales-report',
        method: 'GET',
        success: function(data) {
            var tableBody = $('#salesReportTable tbody');
            tableBody.empty();

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
                    <td><button class="btn btn-primary viewDetailBtn" data-id="${detail.id}">View</button></td>
                </tr>`;
                tableBody.append(row);
            });

            // Add click event to "View" button
            $('.viewDetailBtn').click(function() {
                var insuranceDetailId = $(this).data('id');
                fetchInsuranceDetail(insuranceDetailId);
            });
        },
        error: function(xhr, status, error) {
            alert("Error loading sales report data: " + error);
        }
    });
});

// Function to fetch insurance detail based on ID and show it in off-canvas
// Function to fetch insurance detail based on ID and show it in off-canvas
function fetchInsuranceDetail(insuranceDetailId) {
    $.ajax({
        url: `/api/insurance/details/${insuranceDetailId}`,
        method: 'GET',
        success: function(data) {
            var tabList = $('#insuranceTabs');
            var tabContent = $('#insuranceTabContent');
            tabList.empty();
            tabContent.empty();

            let isFirstTab = true; // Track the first tab for active class assignment

            // Iterate over each table and create a tab and a tab pane
            for (const table in data) {
                const tableName = table.replace('_', ' ').toUpperCase();

                // Create a tab for each table
                const tabId = `tab-${table}`;
                tabList.append(`
                    <li class="nav-item" role="presentation">
                        <button class="nav-link ${isFirstTab ? 'active' : ''}" id="${tabId}-tab" data-bs-toggle="tab" data-bs-target="#${tabId}" type="button" role="tab" aria-controls="${tabId}" aria-selected="${isFirstTab}">
                            ${tableName}
                        </button>
                    </li>
                `);

                // Create a tab pane for each table
                let tableContent = '';
                data[table].forEach(record => {
                    for (const key in record) {
                        tableContent += `<p><strong>${key}</strong>: ${record[key]}</p>`;
                    }
                });

                tabContent.append(`
                    <div class="tab-pane fade ${isFirstTab ? 'show active' : ''}" id="${tabId}" role="tabpanel" aria-labelledby="${tabId}-tab">
                        ${tableContent}
                    </div>
                `);

                isFirstTab = false; // Set to false after the first tab
            }

            // Show the off-canvas component
            var detailOffCanvas = new bootstrap.Offcanvas(document.getElementById('detailOffCanvas'));
            detailOffCanvas.show();
        },
        error: function(xhr, status, error) {
            alert("Error fetching insurance details: " + error);
        }
    });
}


</script>

@endsection
