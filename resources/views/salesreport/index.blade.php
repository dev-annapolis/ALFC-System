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
    
    <!-- Responsive wrapper for the table -->
    <div class="table-responsive">
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
                    const tableName = table.replace('_', ' ').toUpperCase();
                    const tabId = `tab-${table}`;

                    tabList.append(`
                        <li class="nav-item" role="presentation">
                            <button class="nav-link ${isFirstTab ? 'active' : ''}" id="${tabId}-tab" data-bs-toggle="tab" data-bs-target="#${tabId}" type="button" role="tab" aria-controls="${tabId}" aria-selected="${isFirstTab}">
                                ${tableName}
                            </button>
                        </li>
                    `);

                    let tableContent = '';
                    let rowCounter = 0;  // Counter to track rows
                    let titleDisplayed = false; // Track if the title has been displayed

                    if (Array.isArray(data[table])) {
                        // If the data for the table is an array (multiple records)
                        data[table].forEach(record => {
                            // Display title only once for commissioner records
                            if (!titleDisplayed) {
                                titleDisplayed = true;
                            }
                            
                            // Generate content for each record
                            rowCounter = 0;  // Reset counter for each record

                            for (const key in record) {
                                let value = record[key];

                                // Dynamically format the key to match the Blade format
                                let formattedKey = key.replace(/_/g, ' ').replace(/\b\w/g, function(char) {
                                    return char.toUpperCase();
                                });

                                // Start a new row every two inputs
                                if (rowCounter % 2 === 0) {
                                    tableContent += `<div class="row">`;
                                }

                                // Create a div with 'col-md-6' for each input field in a 2x2 grid
                                tableContent += `
                                   <div class="col-md-6 col-sm-6 mb-3">
                                        <div class="form-group">
                                            <label for="${key}"><strong>${formattedKey}</strong></label>
                                            <input type="text" id="${key}" class="form-control" value="${value}" readonly />
                                        </div>
                                    </div>
                                `;

                                // End the row after two columns
                                if (rowCounter % 2 === 1) {
                                    tableContent += `</div>`;
                                }

                                // Increment the row counter
                                rowCounter++;
                            }

                            // Close the last row if it has an odd number of items
                            if (rowCounter % 2 !== 0) {
                                tableContent += `</div>`;
                            }
                        });
                    } else {
                        // If the data for the table is not an array (single record)
                        for (const key in data[table]) {
                            let value = data[table][key];

                            if (typeof value === 'object' && value !== null) {
                                // Skip objects or null values
                                continue;
                            } else {
                                // Dynamically format the key to match the Blade format
                                let formattedKey = key.replace(/_/g, ' ').replace(/\b\w/g, function(char) {
                                    return char.toUpperCase();
                                });

                                // Start a new row every two inputs
                                if (rowCounter % 2 === 0) {
                                    tableContent += `<div class="row">`;
                                }

                                // Create a div with 'col-md-6' for each input field in a 2x2 grid
                                tableContent += `
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="${key}"><strong>${formattedKey}</strong></label>
                                            <input type="text" id="${key}" class="form-control" value="${value}" readonly />
                                        </div>
                                    </div>
                                `;

                                // End the row after two columns
                                if (rowCounter % 2 === 1) {
                                    tableContent += `</div>`;
                                }

                                // Increment the row counter
                                rowCounter++;
                            }
                        }

                        // Close the last row if it has an odd number of items
                        if (rowCounter % 2 !== 0) {
                            tableContent += `</div>`;
                        }
                    }

                    tabContent.append(`
                        <div class="tab-pane fade ${isFirstTab ? 'show active' : ''}" id="${tabId}" role="tabpanel" aria-labelledby="${tabId}-tab">
                            ${tableContent}
                        </div>
                    `);

                    isFirstTab = false; // Set to false after the first tab
                }
            }
        },
        error: function(xhr, status, error) {
            if (xhr.status === 403) {
                $('#insuranceTabContent').html(`
                    <div class="alert alert-info" role="alert">
                        No permissions found to view this insurance record.
                    </div>
                `);
            } else {
                alert("Error fetching insurance details: " + error);
            }
        }
    });
}







</script>

@endsection
