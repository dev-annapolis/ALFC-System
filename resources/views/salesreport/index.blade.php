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

<div class="container-fluid mt-5">
    <h2>Sales Report</h2>
    
    <!-- Responsive wrapper for the table -->
    <div class="table-responsive">
        <table id="salesReportTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>Provider</th>
                    <th>Issuance Code</th>
                    <th>Assured Name</th>
                    <th>Contact Number </br> Email</th>

                    <th>Sales Associate </br>( Sales Team )</th>
                    <th>Branch Manager </br>( Source )</th>
                    <th>Sroduct</th>

                    <th>Sale Date </br> Good As Sales Date </br> Policy Inception Date</th>
                    
                    <th>Sale Status</th>
                    <th>Actions</th> <!-- Added Actions column -->
                </tr>
            </thead>
            <tbody>
                <!-- Table rows will be dynamically inserted here -->
            </tbody>
        </table>
    </div>
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
                    <td>${detail.provider}</td>
                    <td>${detail.issuance_code}</td>
                    <td>${detail.name}</td>
                    <td>${detail.contact_number} </br> ${detail.email}</td>
                    
                    
                    <td>${detail.sales_associate} </br>( ${detail.sales_team} )</td>
                    <td>${detail.branch_manager} </br>( ${detail.source} )</td>
                    <td>${detail.subproduct}</td>

                    <td>${detail.sale_date} </br> ${detail.good_as_sales_date} </br> ${detail.policy_inception_date}</td>
                    
                    <td>${detail.sale_status}</td>
                    <td><button class="btn btn-primary viewDetailBtn" data-id="${detail.id}" data-bs-toggle="offcanvas" data-bs-target="#detailOffCanvas">View</button></td>
                </tr>`;
                tableBody.append(row);
            });

            // Add click event to "View" button
            $('.viewDetailBtn').click(function() {
                var insuranceDetailId = $(this).data('id');
                fetchInsuranceDetail(insuranceDetailId); // Fetches data only
            });
        },
        error: function(xhr, status, error) {
            alert("Error loading sales report data: " + error);
        }
    });

    // Event to clear off-canvas content after it is closed
    $('#detailOffCanvas').on('hidden.bs.offcanvas', function () {
        // Clear tabs and content
        $('#insuranceTabs').empty();
        $('#insuranceTabContent').empty();
    });
});

function fetchInsuranceDetail(insuranceDetailId) {
    $.ajax({
        url: `/api/insurance/details/${insuranceDetailId}`,
        method: 'GET',
        success: function(data) {
            console.log(data); // Check the structure of the data in the console
            var tabList = $('#insuranceTabs');
            var tabContent = $('#insuranceTabContent');
            tabList.empty();
            tabContent.empty();

            // Check if the data object is empty
            if (Object.keys(data).length === 0) {
                tabContent.append(`
                    <div class="alert alert-info" role="alert">
                        No details available for this insurance record.
                    </div>
                `);
            } else {
                let isFirstTab = true; // Track the first tab for active class assignment

                // Iterate over each table and create a tab and a tab pane
                for (const table in data) {
                    const tableData = data[table].data;
                    const editableFields = data[table].editable;
                    const tableName = table.replace('_', ' ').toUpperCase();
                    const tabId = `tab-${table}`;

                    tabList.append(`
                        <li class="nav-item" role="presentation">
                            <button class="nav-link ${isFirstTab ? 'active' : ''}" id="${tabId}-tab" data-bs-toggle="tab" data-bs-target="#${tabId}" type="button" role="tab" aria-controls="${tabId}" aria-selected="${isFirstTab}">
                                ${tableName}
                            </button>
                        </li>
                    `);

                    let tableContent = '<table class="table">';
                    let count = 0;

                    for (const [key, value] of Object.entries(tableData)) {
                        const isEditable = editableFields[key];
                        const formattedKey = key.replace(/_/g, ' ').toUpperCase();

                        // Start a new row every two items
                        if (count % 2 === 0) {
                            tableContent += '<tr>';
                        }

                        tableContent += `
                            <td>
                                <label><strong>${formattedKey}</strong></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="${key}" value="${value}" ${isEditable ? 'readonly' : 'readonly'}>
                                    ${isEditable ? `
                                        <button class="btn btn-outline-primary edit-btn" data-key="${key}">
                                            edit
                                        </button>
                                    ` : ''}
                                </div>
                            </td>
                        `;

                        // Close the row every two items
                        if (count % 2 === 1) {
                            tableContent += '</tr>';
                        }

                        count++;
                    }

                    // If the last row has only one cell, close it with an empty cell for alignment
                    if (count % 2 === 1) {
                        tableContent += '<td></td></tr>';
                    }

                    tableContent += '</table>';

                    tabContent.append(`
                        <div class="tab-pane fade ${isFirstTab ? 'show active' : ''}" id="${tabId}" role="tabpanel" aria-labelledby="${tabId}-tab">
                            ${tableContent}
                        </div>
                    `);
                    isFirstTab = false;
                }

                // Add click event listener for edit buttons
                $('.edit-btn').on('click', function() {
                    const key = $(this).data('key');
                    const inputField = $(`#${key}`);

                    // Log the inputField variable to console

                    // Toggle readonly attribute and focus the field if it becomes editable
                    if (inputField.prop('readonly')) {
                        inputField.prop('readonly', false).focus();
                        $(this).html('save'); // Change icon to a save icon
                    } else {
                        inputField.prop('readonly', true);
                        $(this).html('<i class="fas fa-edit"></i>'); // Change icon back to edit icon

                        // Optionally, you can save the new value to the server here
                        // Example:
                        // $.post(`/api/insurance/details/update`, { key: key, value: inputField.val() });
                    }
                });
            }
        },
        error: function() {
            alert('Failed to fetch insurance details.');
        }
    });
}









</script>

@endsection
