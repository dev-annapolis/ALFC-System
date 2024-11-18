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
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
                    <th>Source </th>
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
                    <td>${detail.source} </td>
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
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    $.ajax({
        url: `/api/insurance/details/${insuranceDetailId}`,
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': csrfToken // Add CSRF token here
        },
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
            console.log("Editable fields for table:", editableFields);

                    tabList.append(`
                        <li class="nav-item" role="presentation">
                            <button class="nav-link ${isFirstTab ? 'active' : ''}" id="${tabId}-tab" data-bs-toggle="tab" data-bs-target="#${tabId}" type="button" role="tab" aria-controls="${tabId}" aria-selected="${isFirstTab}">
                                ${tableName}
                            </button>
                        </li>
                    `);

                    let tableContent = '<table class="table">';
                        if (table === 'insurance_commissioners') {
                            // Render editable input fields for `insurance_commissioners` in a row
                            tableContent = '<div class="row">';
                            tableData.forEach((commissioner, index) => {
                                tableContent += `
                                    <div class="col-md-4 mb-3">
                                        <label for="commissioner-title-${index}" class="form-label"><strong>Commissioner Title</strong></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="commissioner-title-${index}" data-key="commissioner_title-${index}" value="${commissioner.commissioner_title}" readonly>
                                            <button class="btn btn-outline-primary edit-btn" data-key="commissioner-title-${index}" data-index="${index}" data-table="${table}">
                                                Edit
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="commissioner-name-${index}" class="form-label"><strong>Commissioner Name</strong></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="commissioner-name-${index}" data-key="commissioner_name-${index}" value="${commissioner.commissioner_name}" readonly>
                                            <button class="btn btn-outline-primary edit-btn" data-key="commissioner-name-${index}" data-index="${index}" data-table="${table}">
                                                Edit
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="commissioner-amount-${index}" class="form-label"><strong>Amount</strong></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="commissioner-amount-${index}" data-key="commissioner_amount-${index}" value="${commissioner.amount}" readonly>
                                            <button class="btn btn-outline-primary edit-btn" data-key="commissioner-amount-${index}" data-index="${index}" data-table="${table}">
                                                Edit
                                            </button>
                                        </div>
                                    </div>
                                    <hr>
                                `;
                            });
                            tableContent += '</div>';
                        }

                        else {
                                                // Default rendering for other tables
                        tableContent = '<table class="table">';
                        let count = 0;

                        for (const [key, value] of Object.entries(tableData)) {
                            const isEditable = editableFields[key];
                            const formattedKey = key.replace(/_/g, ' ').toUpperCase();

                            if (count % 2 === 0) {
                                tableContent += '<tr>';
                            }

                            tableContent += `  
                                <td>
                                    <label><strong>${formattedKey}</strong></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="${key}" value="${value}" readonly>
                                        ${isEditable ? `
                                            <button class="btn btn-outline-primary edit-btn" data-key="${key}" data-table="${table}">
                                                Edit
                                            </button>
                                        ` : ''}
                                    </div>
                                </td>
                            `;

                            if (count % 2 === 1) {
                                tableContent += '</tr>';
                            }

                            count++;
                        }

                        if (count % 2 === 1) {
                            tableContent += '<td></td></tr>';
                        }

                        tableContent += '</table>';
                    }

                    tabContent.append(`
                        <div class="tab-pane fade ${isFirstTab ? 'show active' : ''}" id="${tabId}" role="tabpanel" aria-labelledby="${tabId}-tab">
                            ${tableContent}
                        </div>
                    `);
                    isFirstTab = false;
                }

                // Function to attach edit event handlers
                function attachEditHandlers() {
                    $('.edit-btn').on('click', function() {
                        const key = $(this).data('key');
                        const inputField = $(`#${key}`);
                        const editButton = $(this);
                        const tableName = $(this).data('table'); // Get the table name from the button's data attribute

                        // Store the original value in case the user cancels
                        const originalValue = inputField.val();

                        // Toggle the editable state and replace button with save and cancel buttons
                        inputField.prop('readonly', false).focus();
                        editButton.replaceWith(`
                            <button class="btn btn-outline-success save-btn" data-key="${key}" data-table="${tableName}">Save</button>
                            <button class="btn btn-outline-secondary cancel-btn" data-key="${key}" data-table="${tableName}">Cancel</button>
                        `);

                        // Add event listener for save button
                        $(`.save-btn[data-key="${key}"]`).on('click', function() {
                            inputField.prop('readonly', true);
                            const newValue = inputField.val();
                            const tableName = $(this).data('table'); // Pass the tableName to save logic

                            // Log the table name, field name (key), and new value to the console
                            console.log(`Table Name: ${tableName}, Field saved: ${key}, New Value: ${newValue}`);

                            // Replace save and cancel buttons with edit button again
                            $(this).replaceWith(`
                                <button class="btn btn-outline-primary edit-btn" data-key="${key}" data-table="${tableName}">Edit</button>
                            `);
                            $(`.cancel-btn[data-key="${key}"]`).remove();

                            // Reattach edit handler to the new edit button
                            attachEditHandlers();

                            // Save the new value to the server here
                            $.ajax({
                                url: `/api/insurance/details/update`,
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken // Add CSRF token here
                                },
                                data: {
                                    table: tableName,
                                    field_name: key,
                                    value: newValue,
                                    insurance_detail_id: insuranceDetailId // Make sure to send the insurance detail ID
                                },
                                success: function(response) {
                                    if (response.success) {
                                        console.log('Field updated successfully:', response.updatedData);
                                    }
                                },
                                error: function(error) {
                                    console.log('Error updating field:', error);
                                }
                            });
                        });

                        // Add event listener for cancel button
                        $(`.cancel-btn[data-key="${key}"]`).on('click', function() {
                            inputField.val(originalValue).prop('readonly', true);

                            // Replace save and cancel buttons with edit button again
                            $(this).replaceWith(`
                                <button class="btn btn-outline-primary edit-btn" data-key="${key}" data-table="${tableName}">Edit</button>
                            `);
                            $(`.save-btn[data-key="${key}"]`).remove();

                            // Reattach edit handler to the new edit button
                            attachEditHandlers();
                        });
                    });
                }

                // Initial attachment of edit handlers
                attachEditHandlers();
            }
        },
        error: function() {
            alert('Failed to fetch insurance details.');
        }
    });
}




</script>

@endsection
