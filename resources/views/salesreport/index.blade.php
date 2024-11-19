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


    const salesAssociates = @json($sales_associates); //for sales_associate_name
    const teams = @json($teams); //for team_name
    const salesManagers = @json($sales_managers); //for sales_manager_name
    const providers = @json($providers); //for provider_name
    const products = @json($products); //for product_name
    const subproducts = @json($subproducts); //for subproduct_name
    const sources = @json($sources); //for source_name
    const sourcebranches = @json($sourcebranches); //for source_branch_name
    const ifgdfis = @json($ifgdfis); //for if_gdfi
    const areas = @json($areas); //for area_name
    const alfcbranches = @json($alfcbranches); //for alfc_branch_name
    const modeofpayments = @json($modeofpayments); //for mode_of_payment_name

    function fetchInsuranceDetail(insuranceDetailId) {
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    $.ajax({
        url: `/api/insurance/details/${insuranceDetailId}`,
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function (data) {
            console.log(data);
            var tabList = $('#insuranceTabs');
            var tabContent = $('#insuranceTabContent');
            tabList.empty();
            tabContent.empty();

            if (Object.keys(data).length === 0) {
                tabContent.append(`
                    <div class="alert alert-info" role="alert">
                        No details available for this insurance record.
                    </div>
                `);
            } else {
                let isFirstTab = true;

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

                    tabContent.append(`
                        <div class="tab-pane fade ${isFirstTab ? 'show active' : ''}" id="${tabId}" role="tabpanel" aria-labelledby="${tabId}-tab">
                            ${tableContent}
                        </div>
                    `);
                    isFirstTab = false;
                }

                function attachEditHandlers() {
                    $('.edit-btn').on('click', function () {
                        const key = $(this).data('key');
                        const inputField = $(`#${key}`);
                        const originalValue = inputField.val();
                        const editButton = $(this);
                        const tableName = $(this).data('table');

                        const dropdownFields = {
                            'sales_associate_name': salesAssociates,
                            'team_name': teams,
                            'sales_manager_name': salesManagers,
                            'provider_name': providers,
                            'product_name': products,
                            'subproduct_name': subproducts,
                            'source_name': sources,
                            'source_branch_name': sourcebranches,
                            'if_gdfi': ifgdfis,
                            'area_name': areas,
                            'alfc_branch_name': alfcbranches,
                            'mode_of_payment_name': modeofpayments
                        };

                        if (key in dropdownFields) {
                            let options = dropdownFields[key];
                            let dropdownHtml = `<select class="form-select" id="${key}">`;
                            options.forEach(option => {
                                dropdownHtml += `
                                    <option value="${option.id}" ${option.name === originalValue ? 'selected' : ''}>
                                        ${option.name}
                                    </option>
                                `;
                            });
                            dropdownHtml += '</select>';

                            inputField.replaceWith(dropdownHtml);

                            editButton.replaceWith(`
                                <button class="btn btn-outline-success save-btn" data-key="${key}" data-table="${tableName}">Save</button>
                                <button class="btn btn-outline-secondary cancel-btn" data-key="${key}" data-table="${tableName}">Cancel</button>
                            `);

                            attachSaveCancelHandlers(key, tableName, originalValue);
                        } else {
                            inputField.prop('readonly', false).focus();
                            editButton.replaceWith(`
                                <button class="btn btn-outline-success save-btn" data-key="${key}" data-table="${tableName}">Save</button>
                                <button class="btn btn-outline-secondary cancel-btn" data-key="${key}" data-table="${tableName}">Cancel</button>
                            `);
                            attachSaveCancelHandlers(key, tableName, originalValue);
                        }
                    });
                }

                function attachSaveCancelHandlers(key, tableName, originalValue) {
                    $(`.save-btn[data-key="${key}"]`).on('click', function () {
                        const newValue = $(`#${key}`).val();
                        const saveButton = $(this);

                        $.ajax({
                            url: `/api/insurance/details/update`,
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                            data: {
                                table: tableName,
                                field_name: key,
                                value: newValue,
                                insurance_detail_id: insuranceDetailId
                            },
                            success: function (response) {
                                if (response.success) {
                                    console.log('Field updated successfully:', response.updatedData);

                                    $(`#${key}`).replaceWith(`<input type="text" class="form-control" id="${key}" value="${response.updatedName || newValue}" readonly>`);

                                    saveButton.replaceWith(`
                                        <button class="btn btn-outline-primary edit-btn" data-key="${key}" data-table="${tableName}">Edit</button>
                                    `);
                                    $(`.cancel-btn[data-key="${key}"]`).remove();
                                    attachEditHandlers();
                                }
                            },
                            error: function (error) {
                                console.log('Error updating field:', error);
                            }
                        });
                    });

                    $(`.cancel-btn[data-key="${key}"]`).on('click', function () {
                        $(`#${key}`).replaceWith(`<input type="text" class="form-control" id="${key}" value="${originalValue}" readonly>`);
                        $(this).replaceWith(`
                            <button class="btn btn-outline-primary edit-btn" data-key="${key}" data-table="${tableName}">Edit</button>
                        `);
                        $(`.save-btn[data-key="${key}"]`).remove();
                        attachEditHandlers();
                    });
                }

                attachEditHandlers();
            }
        },
        error: function () {
            alert('Failed to fetch insurance details.');
        }
    });
}






</script>

@endsection
