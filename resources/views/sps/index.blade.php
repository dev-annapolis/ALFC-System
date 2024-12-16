@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
<style>
/* Container with neumorphic effect */
.neumorphic-container {
    background: var(--background-color);
    border-radius: 12px;
    padding: 15px;
    box-shadow: 8px 8px 16px var(--shadow-dark),
                -8px -8px 16px var(--shadow-light);
}

/* Neumorphic table */
.neumorphic-table {
    background: var(--background-color);
    border-radius: 12px;
    color: var(--text-color);
    box-shadow: inset 4px 4px 8px var(--shadow-dark),
                inset -4px -4px 8px var(--shadow-light);
    overflow: visible;
    white-space: nowrap;        /* Prevent text wrapping */
    text-overflow: ellipsis;    /* Add ellipsis for overflowing text */
    font-size:12px;

}
.neumorphic-table th {
    white-space: nowrap;        /* Prevent text wrapping for header */
    text-overflow: ellipsis;    /* Optional for headers if they have fixed width */
    overflow: hidden;           /* Hide overflow */
}

/* Table header */
.neumorphic-table thead tr {
    background: linear-gradient(145deg, var(--shadow-light), var(--background-color));
    box-shadow: inset 2px 2px 4px var(--shadow-dark),
                inset -2px -2px 4px var(--shadow-light);
}

.neumorphic-table thead th {
    color: var(--text-color);
    font-weight: bold;
    padding: 12px;
    border-bottom: 2px solid var(--shadow-dark);
}

/* Table rows */
.neumorphic-table tbody tr {
    transition: background 0.3s, box-shadow 0.3s;
}

.neumorphic-table tbody tr:hover {
    background: var(--shadow-light);
    box-shadow: 4px 4px 8px var(--shadow-dark),
                -4px -4px 8px var(--shadow-light);
}

/* Table cells */
.neumorphic-table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid var(--shadow-dark);
}

/* Actions button */
.dropdown-toggle::after {
    display: none !important; /* Hides the default Bootstrap caret icon */
}
.dropdown-menu {
    text-align: center;            /* Center the text within the dropdown */
}

.dropdown-item {
    display: flex;                 /* Use flexbox for better alignment */
    justify-content: center;       /* Horizontally center content */
    align-items: center;           /* Vertically center content */
    padding: 10px 15px;            /* Adjust padding for a balanced look */
}

.dropdown-item i {
    margin-right: 5px;             /* Add space between the icon and text */
}

.dropdown-item:hover {
    background-color: #f8f9fa;     /* Slight background change on hover */
    color: #007bff;                /* Text and icon color on hover */
}
#salesReportTable th, 
#salesReportTable td {
    text-align: center; /* Center-align text */
    vertical-align: middle; /* Vertically center the content */
}

.input-custom {
    box-sizing: border-box;
    font-family: inherit;
    font-size: 12px;
    vertical-align: baseline;
    font-weight: 600;
    line-height: 1.29;
    letter-spacing: 0.16px;
    border-radius: 0;
    outline: 2px solid transparent;
    outline-offset: -2px;
    width: 100%;
    height: 30px;
    border: none;
    border-bottom: 1px solid #8d8d8d;
    background-color: #f4f4f4;
    padding: 0 16px;
    color: #161616;
    transition: background-color 70ms cubic-bezier(0.2, 0, 0.38, 0.9), outline 70ms cubic-bezier(0.2, 0, 0.38, 0.9);
}

.input-custom:focus {
    outline: 2px solid #0f62fe;
    outline-offset: -2px;
    height: 30px;

}

.custom-offcanvas{
    font-size:13px;
}

.edit-btn,
.save-btn,
.cancel-btn {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 30px; /* Adjust as needed */
    width: 30px;  /* Adjust as needed */
    padding: 0;
}

.ra-comments {
    max-width: 150px; /* Set your desired width */
    white-space: nowrap; /* Prevent text from wrapping to the next line */
    overflow: hidden; /* Hide the overflow text */
    text-overflow: ellipsis; /* Show ellipsis (...) when text is truncated */
}

.contact-info {
    max-width: 150px; /* Adjust based on your table layout */
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    display: inline-block; /* Ensures the ellipsis is applied correctly */
}
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

<div class="container-fluid mt-5">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#myOffcanvas" aria-controls="myOffcanvas">
        Open Offcanvas
    </button>
     --}}
    <!-- Responsive wrapper for the table -->
 
    <div class="table-responsive neumorphic-container">
        <table id="salesReportTable" class="table table-striped dt-responsive thin-horizontal-lines neumorphic-table" style="width:100%">
            <thead>
                <tr>
                    <th style="text-align: center;">Assured Name<br>(Issuance Code)</th>
                    <th style="text-align: center;">Contact Number </br> Email</th>
                    <th style="text-align: center;">Sales Associate<</th>
                    <th style="text-align: center;">Sales Team </th>
                    <th style="text-align: center;">Provider</th>
                    <th style="text-align: center;">Source</th>
                    <th style="text-align: center;">Subproduct</th>
                    <th style="text-align: center;">Sale Date </br> Good As Sales Date </br> Policy Inception Date</th>
                    <th style="text-align: center;">RA Comments</th>
                    <th style="text-align: center;">Sale Status</th>
                    <th style="text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Table rows will be dynamically inserted here -->
            </tbody>
        </table>
    </div>

    <div class="custom-offcanvas offcanvas offcanvas-end" tabindex="-1" id="detailOffCanvas" aria-labelledby="detailOffCanvasLabel" data-bs-backdrop="false">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="detailOffCanvasLabel"></h5>
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
    <div class="offcanvas offcanvas-start" tabindex="-1" id="myOffcanvas" aria-labelledby="myOffcanvasLabel" data-bs-backdrop="false">
        <div class="offcanvas-header">
            <h5 id="myOffcanvasLabel">Custom Filter</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            
            <form id="filterForm">
                <!-- Dropdown filters will be inserted here dynamically -->
                <div id="filterDropdowns"></div>
            </form>

        </div>
    </div>
    {{-- comment modal --}}
    <div id="addCommentModal" class="modal fade" tabindex="-1" aria-labelledby="addCommentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCommentModalLabel">RA Comment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <textarea id="commentInput" class="form-control" rows="4" placeholder="Enter your comment here..." readonly></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Checklist Modal -->
    <div class="modal fade" id="checklistModal" tabindex="-1" aria-labelledby="checklistModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="checklistModalLabel">Checklist</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="checklistContainer">
                    <!-- Dynamically loaded checklist items will appear here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="saveChecklistChanges()">Save Changes</button>
                </div>
            </div>
        </div>
    </div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
<!-- Choices.js CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
<!-- Choices.js JS -->
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<!-- Daterangepicker JS -->
<script src="https://cdn.jsdelivr.net/npm/moment/min/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<!-- Add these in the <head> section or before the closing </body> tag -->
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script> -->


<script>
    function saveChecklistChanges() {
        const checklistContainer = document.getElementById('checklistContainer');
        const checkboxes = checklistContainer.querySelectorAll('.form-check-input');

        const changes = Array.from(checkboxes).map(checkbox => ({
            id: checkbox.id.split('-')[1], // Extract the ID from the `checklist-{id}`
            completed: checkbox.checked ? 1 : 0
        }));
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        $.ajax({
            url: '/api/checklist/save', // Update with your endpoint for saving checklist changes
            method: 'POST', // Or PUT if you're updating existing records
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            contentType: 'application/json',
            data: JSON.stringify(changes),
            success: function (response) {
                alert('Checklist changes saved successfully!');
                $('#checklistModal').modal('hide'); // Optionally close the modal
            },
            error: function (xhr, status, error) {
                alert('Error saving checklist changes: ' + error);
            }
        });
    }


   $(document).ready(function () {

    //TABLE
        const table = $('#salesReportTable').DataTable({
            responsive: true,
            autoWidth: false,
            order: [[0, 'asc']], // Default sorting on the first column
            dom: '<"row TOP-ROW"<"col-md-6 MASTER-LIST"><"col-md-6 pb-3 SEARCHING "f>>t<"row"<"col-md-6 pt-3"l><"col-md-6 pt-2"p>>',
                initComplete: function () {
                    // Add the header to the MASTER-LIST column
                    $('.MASTER-LIST').html('<h1><span style="color: #FF3832;"><b>SPS</b></span> Masterlist</h1>');

                    // Wrap the search field and button in a flex container
                    $('.SEARCHING').addClass('d-flex align-items-center justify-content-end');
            
                    // Append the button next to the search bar
                    $('.SEARCHING').append(`
                        <button class="btn  ms-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#myOffcanvas" aria-controls="myOffcanvas">
                            <i class="fa-solid fa-filter"></i>
                        </button>
                    `);
                },
            columns: [
                { title: "Assured &<br> Issuance Code" },  // Column 0
                { title: "Contact Info" },   // Column 1
                { title: "Sales Associate" },// Column 2
                { title: "Teams" },          // Column 3
                { title: "Provider" },       // Column 4
                { title: "Source" },         // Column 5
                { title: "Subproduct" },     // Column 6
                { title: "Dates" },          // Column 7
                { title: "RA Comments" },    // Column 8
                { title: "Status" },         // Column 9
                { title: "Actions", orderable: false } // Column 10
            ]
        });

        $.ajax({
            url: '/api/sps-index',
            method: 'GET',
            success: function (data) {
                table.clear();

                const statusColors = {
                    'reinstated': '#ffc107',
                        'sale': '#28a745',
                        'cancelled': '#dc3545',
                };

                function getStatusColor(status) {
                    return statusColors[status] || '#6c757d'; // Default to gray
                }

                data.forEach(function (detail) {
                    const saleDates = `
                        ${detail.sale_date ? `<div><strong>Sale Date:</strong> ${detail.sale_date}</div>` : ''}
                        ${detail.good_as_sales_date ? `<div><strong>Good As Sales Date:</strong> ${detail.good_as_sales_date}</div>` : ''}
                        ${detail.policy_inception_date ? `<div><strong>Policy Inception Date:</strong> ${detail.policy_inception_date}</div>` : ''}
                    `;
                    table.row.add([
                        `<strong>${detail.name}</strong> <br>${detail.issuance_code}`,
                        `<div class="contact-info" title="${detail.contact_number} \n${detail.email}">
                            ${detail.contact_number} <br> ${detail.email}
                        </div>`,
                        `${detail.sales_associate}`,
                        `${detail.sales_team}`,
                        detail.provider,
                        detail.source,
                        detail.subproduct,
                        saleDates,
                        `<div class="ra-comments" title="${detail.ra_comments}" data-bs-toggle="modal" data-bs-target="#addCommentModal" data-comment="${detail.ra_comments}">
                            ${detail.ra_comments}
                        </div>`,
                        `<span style="color: ${getStatusColor(detail.sale_status)}; font-weight: bold;">${detail.sale_status}</span>`,
                        `<div class="dropdown">
                            <button class="btn dropdown-toggle p-2 border-0 bg-transparent circular-btn" 
                                    type="button" 
                                    id="dropdownMenuButton${detail.id}" 
                                    data-bs-toggle="dropdown" 
                                    aria-expanded="false">
                                <i class="fa-solid fa-ellipsis"></i>
                            </button>
                            <ul class="dropdown-menu text-center" aria-labelledby="dropdownMenuButton${detail.id}">
                                <li>
                                    <a 
                                        class="dropdown-item viewDetailBtn d-flex justify-content-center align-items-center" 
                                        href="#" 
                                        data-id="${detail.id}" 
                                        data-bs-toggle="offcanvas" 
                                        data-bs-target="#detailOffCanvas">
                                        <i class="fa-regular fa-eye me-2"></i> View
                                    </a>
                                </li>
                                <li>
                                    <a 
                                        class="dropdown-item checklistBtn d-flex justify-content-center align-items-center" 
                                        href="#" 
                                        data-id="${detail.id}" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#checklistModal">
                                        <i class="fa-regular fa fa-list-alt me-2"></i> Checklist
                                    </a>
                                </li>
                            </ul>
                        </div>
                        `
                    ]);
                });

                table.draw();

                // Add event listener to "View" buttons
                $('.viewDetailBtn').click(function () {
                    var insuranceDetailId = $(this).data('id');
                    fetchInsuranceDetail(insuranceDetailId); // Fetches data only
                });

                $(document).on('click', '.checklistBtn', function () {
                    const insuranceDetailId = $(this).data('id');
                    fetchChecklist(insuranceDetailId);
                });


                // document.querySelectorAll('.checklistBtn').forEach(button => {
                //     button.addEventListener('click', function () {
                //         const detailId = this.getAttribute('data-id');
                //         document.getElementById('checklistDetailId').textContent = detailId;
                //         fetchChecklist(detailId); 
                //         // Additional logic to fetch and display data can go here
                //     });
                // });


                populateFilters(data);
            },
            error: function (xhr, status, error) {
                alert("Error loading sales report data: " + error);
            }
        });
        //END TABLE


    //OFF CANVASS DETAILS FUNCTION WITH EDIT
    //============================================================================================================================

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
    const teles = @json($teles); //for tele_name
    const commissioners = @json($commissioners); //for commissioner_title

    //============================================================================================================================

    function fetchChecklist(detailId) {
        console.log(detailId);
        $.ajax({
            url: `/api/checklist/${detailId}`,
            method: 'GET',
            success: function (data) {
                const checklistContainer = document.getElementById('checklistContainer');
                checklistContainer.innerHTML = '';

                // Group data by titles
                const groupedByTitle = data.reduce((acc, item) => {
                    const title = item.payment_checklist?.mode_of_payment?.name || 'Unknown MOP';
                    acc[title] = acc[title] || [];
                    acc[title].push(item);
                    return acc;
                }, {});

                // Render grouped checklist items
                for (const [title, items] of Object.entries(groupedByTitle)) {
                    const titleElement = `<h5>${title}</h5>`;
                    const checklistItems = items.map(item => `
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="checklist-${item.id}" ${item.completed ? 'checked' : ''}>
                            <label class="form-check-label" for="checklist-${item.id}">
                                ${item.payment_checklist?.name || 'Unnamed Checklist'}
                            </label>
                        </div>
                    `).join('');
                    checklistContainer.innerHTML += `${titleElement}${checklistItems}`;
                }
            },
            error: function (xhr, status, error) {
                alert("Error loading checklist: " + error);
            }
        });
    }

    




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

                        let tableContent = '';

                        if (table === 'insurance_commissioners') {
                            tableContent = '<div class="row">';
                            tableData.forEach((commissioner, index) => {
                                tableContent += `
                                    <div class="col-md-4 mb-3">
                                        <label for="commissioner_title-${index}" class="form-label"><strong>Commissioner Title</strong></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control input-custom" id="commissioner_title-${index}" value="${commissioner.commissioner_title}" readonly>
                                            ${editableFields.commissioner_title ? `
                                                <button class="btn btn-outline-primary edit-btn" data-key="commissioner_title-${index}" data-index="${index}" data-table="${table}">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </button>
                                            ` : ''}
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="commissioner_name-${index}" class="form-label"><strong>Commissioner Name</strong></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control input-custom" id="commissioner_name-${index}" value="${commissioner.commissioner_name}" readonly>
                                            ${editableFields.commissioner_name ? `
                                                <button class="btn btn-outline-primary edit-btn" data-key="commissioner_title-${index}" data-index="${index}" data-table="${table}">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </button>
                                            ` : ''}
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="amount-${index}" class="form-label"><strong>Amount</strong></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control input-custom" id="amount-${index}" value="${commissioner.amount}" readonly>
                                            ${editableFields.amount ? `
                                                <button class="btn btn-outline-primary edit-btn" data-key="commissioner_title-${index}" data-index="${index}" data-table="${table}">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </button>
                                            ` : ''}
                                        </div>
                                    </div>
                                    <hr>
                                `;
                            });
                            tableContent += '</div>';
                        } else {
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
                                            <input type="text" class="form-control input-custom" id="${key}" value="${value}" readonly>
                                            ${isEditable ? `
                                                <button class="btn btn-outline-primary edit-btn" data-key="${key}" data-table="${table}">
                                                    <i class="fa-regular fa-pen-to-square"></i>
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
        

                    function attachEditHandlers() {
                        $('.edit-btn').on('click', function () {
                            const fullKey = $(this).data('key'); // e.g., "commissioner_title-0"
                            const tableName = $(this).data('table');
                            const inputField = $(`#${fullKey}`); // The input field for this key
                            const editButton = $(this);

                            // Split the full key into baseKey and index
                            const [baseKey, index] = fullKey.split('-'); // "commissioner_title-0" -> ["commissioner_title", "0"]

                            // Define dropdown fields with lookup functionality
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
                                'mode_of_payment_name': modeofpayments,
                                'tele_name': teles,
                                'commissioner_title': commissioners // Adjusted for indexed fields
                            };

                            let originalValue;

                            if (baseKey in dropdownFields) {
                                // Fetch the current value from the input field
                                const currentValue = inputField.val();

                                // Convert ID to name if the currentValue is an ID
                                const options = dropdownFields[baseKey]; // Use baseKey for lookup
                                const matchedOption = options.find(option => option.id == currentValue);
                                originalValue = matchedOption ? matchedOption.name : currentValue;

                                console.log(`Original value of ${fullKey}:`, originalValue); // Log the name
                            } else {
                                // For non-dropdown fields, use the input field value
                                originalValue = inputField.val();
                                console.log(`Original value of ${fullKey}:`, originalValue); // Log the value
                            }

                            // Replace input field with a dropdown if baseKey is in dropdownFields
                            if (baseKey in dropdownFields) {
                                let options = dropdownFields[baseKey];
                                let dropdownHtml = `<select class="form-select input-custom" id="${fullKey}">`; // Use fullKey to maintain unique IDs
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
                                    <button class="btn btn-outline-success save-btn" data-key="${fullKey}" data-table="${tableName}"> <i class="fa-solid fa-check"></i></button>
                                    <button class="btn btn-outline-secondary cancel-btn" data-key="${fullKey}" data-table="${tableName}"><i class="fa-solid fa-x"></i></button>
                                `);

                                attachSaveCancelHandlers(fullKey, tableName, originalValue); // Pass the fullKey
                            } else {
                                // For normal input fields
                                inputField.prop('readonly', false).focus();
                                editButton.replaceWith(`
                                    <button class="btn btn-outline-success save-btn" data-key="${fullKey}" data-table="${tableName}"> <i class="fa-solid fa-check"></i></button>
                                    <button class="btn btn-outline-secondary cancel-btn" data-key="${fullKey}" data-table="${tableName}"><i class="fa-solid fa-x"></i></button>
                                `);
                                attachSaveCancelHandlers(fullKey, tableName, originalValue); // Pass the fullKey
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

                                        $(`#${key}`).replaceWith(`<input type="text" class="form-control input-custom" id="${key}" value="${response.updatedName || newValue}" readonly>`);

                                        saveButton.replaceWith(`
                                            <button class="btn btn-outline-primary edit-btn" data-key="${key}" data-table="${tableName}">Edit</button>
                                        `);
                                        $(`.cancel-btn[data-key="${key}"]`).remove();
                                        attachEditHandlers();
                                        fetchInsuranceDetail(insuranceDetailId);
                                    }
                                },
                                error: function (error) {
                                    console.log('Error updating field:', error);
                                }
                            });
                        });

                        $(`.cancel-btn[data-key="${key}"]`).on('click', function () {
                            $(`#${key}`).replaceWith(`<input type="text" class="form-control input-custom"  id="${key}" value="${originalValue}" readonly>`);
                            $(this).replaceWith(`
                                <button class="btn btn-outline-primary edit-btn" data-key="${key}" data-table="${tableName}">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </button>
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
    //END OFF CANVASS DETAILS FUNCTION WITH EDIT

    //FILTER ON OFF CANVASS
        function populateFilters(data) {
            const uniqueColumns = ['sales_associate', 'sales_team', 'provider', 'source', 'subproduct'];
            const filterDropdowns = $('#filterDropdowns');
            filterDropdowns.empty();

            uniqueColumns.forEach(function (column) {
                let distinctValues = [...new Set(data.map(item => item[column]?.trim()))];
                const options = [''].concat(distinctValues); // "All" as an empty string is always at the top

                const dropdown = `
                    <div class="mb-3">
                        <label for="${column}Filter">${column.charAt(0).toUpperCase() + column.slice(1)}</label>
                        <select class="form-select" id="${column}Filter">
                            ${options.map(value => `<option value="${value}">${value || "All"}</option>`).join('')}
                        </select>
                    </div>`;
                filterDropdowns.append(dropdown);

                const choices = new Choices(`#${column}Filter`, {
                    searchEnabled: true,
                    removeItemButton: false,
                    itemSelectText: '',
                    placeholder: true,
                    placeholderValue: `Select ${column}`,
                    sorter: (a, b) => {
                        if (a.value === "" || b.value === "") {
                            return a.value === "" ? -1 : 1; 
                        }
                        return a.value.localeCompare(b.value);
                    }
                });
            });

            // Add separate date filter dropdowns
            $('#filterDropdowns').append(`
                <div class="mb-3">
                    <label for="saleDateFilter">Sale Date</label>
                    <input type="text" id="saleDateFilter" class="form-control" placeholder="Select sale date" readonly />
                </div>
                <div class="mb-3">
                    <label for="goodAsSaleDateFilter">Good As Sales Date</label>
                    <input type="text" id="goodAsSaleDateFilter" class="form-control" placeholder="Select good as sales date" readonly />
                </div>
                <div class="mb-3">
                    <label for="policyInceptionDateFilter">Policy Inception Date</label>
                    <input type="text" id="policyInceptionDateFilter" class="form-control" placeholder="Select policy inception date" readonly />
                </div>
            `);

            // Initialize date range pickers
            $('#saleDateFilter, #goodAsSaleDateFilter, #policyInceptionDateFilter').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                }
            });

            // Set event listeners for applying date filters
            $('#saleDateFilter, #goodAsSaleDateFilter, #policyInceptionDateFilter').on('apply.daterangepicker', function (ev, picker) {
                const startDate = picker.startDate.format('YYYY-MM-DD');
                const endDate = picker.endDate.format('YYYY-MM-DD');
                $(this).val(`${startDate} - ${endDate}`);
                table.draw(); // Trigger the table redraw
            });

            // Clear date range filters
            $('#saleDateFilter, #goodAsSaleDateFilter, #policyInceptionDateFilter').on('cancel.daterangepicker', function () {
                $(this).val('');
                table.draw(); // Trigger the table redraw
            });

            // Attach change event to other filters
            filterDropdowns.find('select').change(function () {
                const selectedFilters = getSelectedFilters();
                applyFilters(selectedFilters);
            });
        }

        $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
            const saleDateRange = $('#saleDateFilter').val();
            const goodAsSaleDateRange = $('#goodAsSaleDateFilter').val();
            const policyInceptionDateRange = $('#policyInceptionDateFilter').val();

            const saleDate = data[8].match(/Sale Date: (\d{4}-\d{2}-\d{2})/);
            const goodAsSaleDate = data[8].match(/Good As Sales Date: (\d{4}-\d{2}-\d{2})/);
            const policyInceptionDate = data[8].match(/Policy Inception Date: (\d{4}-\d{2}-\d{2})/);

            const dateFilters = [
                { value: saleDateRange, date: saleDate },
                { value: goodAsSaleDateRange, date: goodAsSaleDate },
                { value: policyInceptionDateRange, date: policyInceptionDate }
            ];

            return dateFilters.every(function (filter) {
                if (!filter.value) return true; // No filter applied
                const [startDate, endDate] = filter.value.split(' - ');
                const dateMoment = moment(filter.date ? filter.date[1] : "", 'YYYY-MM-DD'); 
                return dateMoment.isBetween(moment(startDate, 'YYYY-MM-DD'), moment(endDate, 'YYYY-MM-DD'), null, '[]');
            });
        });

        function getSelectedFilters() {
            const filters = {};
            $('#filterDropdowns select').each(function () {
                const column = $(this).attr('id').replace('Filter', '');
                const value = $(this).val();
                filters[column] = value || "";
            });
            return filters;
        }

        function applyFilters(filters) {
            const columnMap = {
                'sales_associate': 2,
                'sales_team': 3,
                'provider': 4,
                'source': 5,
                'subproduct': 6
            };
            
            Object.keys(filters).forEach(function (key) {
                const columnIndex = columnMap[key];
                const value = filters[key];
                if (columnIndex !== undefined) {
                    table.column(columnIndex).search(value, false, false).draw();
                }
            });
        }
    });
    //END FILTER

    //OFF CANVASS RESIZE LOGIC
        // Event to clear off-canvas content after it is closed
        $('#detailOffCanvas').on('hidden.bs.offcanvas', function () {
            // Clear tabs and content
            $('#insuranceTabs').empty();
            $('#insuranceTabContent').empty();
        });

        const offcanvas = document.getElementById('detailOffCanvas');

        // Create and style the resize handle
        const resizeHandle = document.createElement('div');
        resizeHandle.style.width = '10px';
        resizeHandle.style.height = '100%';
        resizeHandle.style.background = '#ccc';
        resizeHandle.style.cursor = 'ew-resize';
        resizeHandle.style.position = 'absolute';
        resizeHandle.style.top = '0';
        resizeHandle.style.left = '-5px'; /* Slight overlap for better usability */
        resizeHandle.style.zIndex = '1050';

        offcanvas.appendChild(resizeHandle);

        let isDragging = false;
        let startX = 0;
        let startWidth = 0;

        // Helper to calculate dynamic min and max width based on screen size
        function getDynamicMinWidth() {
            return 200; // Set your minimum width in pixels
        }

        function getDynamicMaxWidth() {
            return window.innerWidth < 992 ? window.innerWidth : Math.floor(window.innerWidth * 0.65);
        }

        // Start resizing on mousedown
        resizeHandle.addEventListener('mousedown', function (e) {
            isDragging = true;
            startX = e.clientX;
            startWidth = offcanvas.offsetWidth;

            // Disable text selection while resizing
            document.body.style.userSelect = 'none';
            document.body.style.cursor = 'ew-resize';
        });

        // Resize the offcanvas on mousemove
        document.addEventListener('mousemove', function (e) {
            if (!isDragging) return;

            const deltaX = startX - e.clientX; // Calculate the change in mouse position
            let newWidth = startWidth + deltaX;

            // Constrain the width to min and max values
            newWidth = Math.max(getDynamicMinWidth(), Math.min(getDynamicMaxWidth(), newWidth));

            offcanvas.style.width = newWidth + 'px';
        });

        // Stop resizing on mouseup
        document.addEventListener('mouseup', function () {
            if (isDragging) {
                isDragging = false;
                document.body.style.userSelect = ''; // Restore text selection
                document.body.style.cursor = ''; // Restore default cursor
            }
        });

        // Set initial width based on screen size
        function setInitialWidth() {
            if (window.innerWidth >= 992) {
                offcanvas.style.width = '35%'; // Default 35% for large screens
            } else {
                offcanvas.style.width = '100%'; // Default 100% for small screens
            }
        }

        // Call the initial setup and handle window resizing
        setInitialWidth();
        window.addEventListener('resize', setInitialWidth);



    //END OFF CANVASS RESIZE LOGIC


    //COMMENT MODAL
    $(document).on('click', '.ra-comments', function () {
        const comment = $(this).data('comment'); // Fetch the comment text
        $('#commentInput').val(comment); // Set the textarea with the comment
    });
    //END COMMENT MODAL




</script>

@endsection

