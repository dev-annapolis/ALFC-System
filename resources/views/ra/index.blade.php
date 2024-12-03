@extends('layouts.app')

@section('content')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

<style>

    .neumorphic-container {
        background: var(--background-color);
        border-radius: 12px;
        padding: 15px;
        box-shadow: 8px 8px 16px var(--shadow-dark),
                    -8px -8px 16px var(--shadow-light);
    }

    .neumorphic-table {
        background: var(--background-color);
        border-radius: 12px;
        color: var(--text-color);
        box-shadow: inset 4px 4px 8px var(--shadow-dark),
                    inset -4px -4px 8px var(--shadow-light);
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        
    }
  
    /* Prevent wrapping and show ellipsis for ra_comments */
    .nowrap-ellipsis {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 200px; /* Adjust based on your desired column width */
    }

    .dropdown-toggle::after {
        display: none !important; /* Hides the default Bootstrap caret icon */
    }

    .text-center{
        text-align: center;
    }
    .text-center-bold{
        text-align: center;
        font-weight:bold;
    }
    #raTable th,
    #raTable td{
        text-align: center; /* Center-align text */
    vertical-align: middle; /* Vertically center the content */
    }

</style>
<div class="container-fluid mt-5" > 
    <div class="table-responsive neumorphic-container"> 
        <table id="raTable" class="table table-striped dt-responsive thin-horizontal-lines neumorphic-table" style="width:100%">
            <thead>
                <tr>
                    <th style="text-align: center;">Issuance<br> Code</th>
                    <th style="text-align: center;">Name</th>
                    <th style="text-align: center;">Policy, Plate <br>Details & PR Number</th>
                    <th style="text-align: center;">Mode of <br>Payment</th>
                    <th style="text-align: center;">SA & Team</th>
                    <th style="text-align: center;">Premium Details <br>(Gross, Discount,<br> Amount Due)</th>
                    <th style="text-align: center;">Sales Credit <br>(Amount & Percent)</th>
                    <th style="text-align: center;">Sale Dates <br>(Sale Date & Good as Sales)</th>
                    <th style="text-align: center;">Status</th>
                    <th style="text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Dynamic content from DataTable -->
            </tbody>
        </table>
    </div>
</div>

<div id="commentModal" class="modal fade" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="commentModalLabel">RA Comments</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="commentText"></p> <!-- This will hold the full comment -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
{{-- commission modal --}}
<div class="modal fade" id="commissionModal" tabindex="-1" aria-labelledby="commissionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="commissionModalLabel">Insurance Commissioners</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Commissioner Title</th>
                            <th>Commissioner Name</th>
                            <th>Amount</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="commissionTableBody">
                        <!-- Rows populated dynamically -->
                    </tbody>
                </table>
                <button class="btn btn-primary" id="addCommissioner">Add Commissioner</button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="saveChanges">Save Changes</button>
            </div>
        </div>
    </div>
</div>



<script>
    const allCommissioners = @json($commissioners);

  $(document).ready(function () {
    // Initialize DataTable
    
    let table = $('#raTable').DataTable({
        processing: true,
        serverSide: false,
        searching: true,
        ajax: {
            url: '/api/ra-index',
            type: 'GET',
            data: function (d) {
                d.team_ids = getSelectedTeamIds(); // Send selected team IDs
            },
        },
        dom: '<"row TOP-ROW"<"col-md-6 MASTER-LIST"><"col-md-6 pb-3 SEARCHING "f>>t<"row"<"col-md-6 pt-3"l><"col-md-6 pt-2"p>>',
        initComplete: function () {
            // Add the header to the MASTER-LIST column
            $('.MASTER-LIST').html('<h1><span style="color: #FF3832;"><b>RA</b></span> Masterlist</h1>');

            // Wrap the search field and button in a flex container
            $('.SEARCHING').addClass('d-flex align-items-center justify-content-end');
            $('.SEARCHING').append(`
                <div class="dropdown ms-2 custom-dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                        style="cursor: pointer; 
                            outline: 0; 
                            display: inline-block; 
                            font-weight: 400; 
                            line-height: 1; 
                            text-align: center; 
                            background-color: transparent; 
                            border: 2px solid #0d6efd; 
                            padding: 6px 12px; 
                            font-size: 1rem; 
                            border-radius: 1rem; 
                            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out; 
                            color: #0d6efd;">
                        Filter by Teams
                    </button>
                    <div class="dropdown-menu p-3 custom-dropdown-menu">
                        @foreach($teams as $team)
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input team-filter" value="{{ $team->id }}" id="team_{{ $team->id }}" />
                            <label class="form-check-label" for="team_{{ $team->id }}">{{ $team->name }}</label>
                        </div>
                        @endforeach
                        <button id="applyFilter" class="btn btn-success mt-3 w-100">Apply Filter</button>
                    </div>
                </div>
            `);
            $(document).on('click', '#applyFilter', function () {
                table.ajax.reload(); // Reload the table with the new filter criteria
            });
        },
        
        columns: [
            { data: 'issuance_code', className: 'text-center-bold', searchable: true },
            { data: 'name', className: 'text-center-bold', searchable: true },
            {
                data: 'policy_number',
                render: function (data, type) {
                    if (type === 'display') {
                        return `<span class="text-muted">Policy Number: </span><strong>${data ?? 'N/A'}</strong>`;
                    }
                    return data ?? ''; // Raw data for search
                },
                searchable: true,
            },
            { data: 'mode_of_payment', className: 'text-center', searchable: true },
            {
                data: null,
                render: function (data, type) {
                    if (type === 'display') {
                        return `<strong>${data.sales_associate ?? 'N/A'}</strong><br><span class="text-muted">(${data.sales_team ?? 'N/A'})</span>`;
                    }
                    return `${data.sales_associate ?? ''} ${data.sales_team ?? ''}`; // Raw data for search
                },
                searchable: true,
                className: 'text-center',
            },
            {
                data: null,
                render: function (data, type) {
                    if (type === 'display') {
                        const grossPremium = data.gross_premium ?? 'N/A';
                        const discount = data.discount ?? 'N/A';
                        const amountDue = data.amount_due_to_provider ?? 'N/A';
                        return `<span class="text-muted">Gross Premium: </span><strong>${grossPremium}</strong><br><span class="text-muted">Discount: </span><strong>${discount}</strong><br><span class="text-muted">Amount Due: </span><strong>${amountDue}</strong>`;
                    }
                    return `${data.gross_premium ?? ''} ${data.discount ?? ''} ${data.amount_due_to_provider ?? ''}`; // Raw data for search
                },
                searchable: true,
            },
            {
                data: null,
                render: function (data, type) {
                    if (type === 'display') {
                        return `<strong>${data.sales_credit ?? 'N/A'}</strong> (${data.sales_credit_percent ?? '0'}%)`;
                    }
                    return `${data.sales_credit ?? ''} ${data.sales_credit_percent ?? ''}`; // Raw data for search
                },
                searchable: true,
                className: 'text-center',
            },
            {
                data: null,
                render: function (data, type) {
                    if (type === 'display') {
                        const formatDate = (date) => {
                            if (!date) return 'N/A'; // Handle null or undefined dates
                            const parsedDate = new Date(date);
                            if (isNaN(parsedDate)) return 'N/A'; // Handle invalid dates
                            return new Intl.DateTimeFormat('en-US', { month: 'short', day: 'numeric', year: 'numeric' }).format(parsedDate);
                        };

                        const saleDate = formatDate(data.sale_date);
                        const goodAsSalesDate = formatDate(data.date_of_good_as_sales);

                        return `<span class="text-muted">Sale Date: </span><strong>${saleDate}</strong><br><span class="text-muted">Good as Sales Date: </span><strong>${goodAsSalesDate}</strong>`;
                    }
                    return `${data.sale_date ?? ''} ${data.date_of_good_as_sales ?? ''}`; // Raw data for search
                },
                searchable: true,
            },
            {
                data: 'status',
                render: function (data) {
                    const statusColors = {
                        'Pending': '#ffc107',
                        'Approved': '#28a745',
                        'Cancelled': '#dc3545',
                        'In Progress': '#17a2b8',
                    };

                    const color = statusColors[data] || '#000'; // Default color is black if status doesn't match
                    return `<span style="color: ${color}; font-weight: bold;">${data}</span>`;
                },
                className: 'text-center',
                searchable: true,
            },
            {
                data: null,
                createdCell: function (td, cellData, rowData) {
                    // Set data-insurance-details-id for each row
                    $(td).closest('tr').attr('data-insurance-details-id', rowData.id);
                },
                render: function (data, type, row) {
                    return `
                        <div class="dropdown"> 
                            <button class="btn dropdown-toggle p-2 border-0 bg-transparent circular-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-ellipsis"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item view-commission" href="#" data-insurance-id="${row.id}">
                                        View Commission
                                    </a>
                                </li>
                                <li><a class="dropdown-item" href="#">Action 2</a></li>
                                <li><a class="dropdown-item" href="#">Action 3</a></li>
                            </ul>
                        </div>
                    `;
                },
                className: 'text-center',
            },
        ],
    });



// Populate modal table
$(document).on('click', '.dropdown-item.view-commission', function () {
    const insuranceDetailsId = $(this).closest('tr').data('insurance-details-id');
    $.ajax({
        url: `/api/view-commission/${insuranceDetailsId}`,
        method: 'GET',
        success: function (response) {
            if (response.success) {
                $('#commissionTableBody').empty();
                response.data.forEach(commission => {
                    const dropdown = generateTitleDropdown(
                        commission.commissioner_id, 
                        allCommissioners
                    );
                    const row = `
                        <tr data-id="${commission.id}">
                            <td>${dropdown}</td>
                            <td contenteditable="true" class="commissioner-name">${commission.commissioner_name}</td>
                            <td contenteditable="true" class="commission-amount">${commission.amount}</td>
                            <td>
                                <button class="btn btn-danger btn-sm delete-commissioner">Delete</button>
                            </td>
                        </tr>
                    `;
                    $('#commissionTableBody').append(row);
                });
                $('#commissionModal').modal('show');
                $('#commissionModal').data('insurance-details-id', insuranceDetailsId);
            } else {
                alert('Failed to fetch data.');
            }
        },
        error: function () {
            alert('An error occurred while fetching data.');
        }
    });
});

// Generate dropdown for Commissioner Title
function generateTitleDropdown(selectedId, commissioners) {
    let options = commissioners.map(comm => {
        return `<option value="${comm.id}" ${comm.id == selectedId ? 'selected' : ''}>${comm.name}</option>`;
    }).join('');
    return `<select class="form-select commissioner-title">${options}</select>`;
}

// Add Commissioner
$('#addCommissioner').on('click', function () {
    const dropdown = generateTitleDropdown(null, allCommissioners);
    const newRow = `
        <tr>
            <td>${dropdown}</td>
            <td contenteditable="true" class="commissioner-name"> </td>
            <td contenteditable="true" class="commission-amount">0</td>
            <td>
                <button class="btn btn-danger btn-sm delete-commissioner">Delete</button>
            </td>
        </tr>
    `;
    $('#commissionTableBody').append(newRow);
});

// Delete Commissioner
$(document).on('click', '.delete-commissioner', function () {
    $(this).closest('tr').remove();
});

// Save Changes
$('#saveChanges').on('click', function () {
    const updatedData = [];
    $('#commissionTableBody tr').each(function () {
        const row = $(this);
        updatedData.push({
            id: row.data('id'),
            commissioner_id: row.find('.commissioner-title').val(), // Dropdown value
            commissioner_name: row.find('.commissioner-name').text(), // Editable string
            amount: row.find('.commission-amount').text(), // Editable string
        });
    });

    const insuranceDetailsId = $('#commissionModal').data('insurance-details-id');

    $.ajax({
        url: `/api/update-commission/${insuranceDetailsId}`,
        method: 'POST',
        data: {
            commissioners: updatedData,
            _token: $('meta[name="csrf-token"]').attr('content'),
        },
        success: function (response) {
            if (response.success) {
                alert('Changes saved successfully!');
                $('#commissionModal').modal('hide');
            } else {
                alert('Failed to save changes.');
            }
        },
        error: function () {
            alert('An error occurred while saving changes.');
        }
    });
});



    // Function to get selected team IDs
    function getSelectedTeamIds() {
        let teamIds = [];
        $('.team-filter:checked').each(function () {
            teamIds.push($(this).val());
            console.log(teamIds); // Debugging: Ensure the correct IDs are logged
        });
        return teamIds.length > 0 ? teamIds : null; // Return null if no teams selected
    }
        // Reload DataTable when Apply Filter is clicked
    });


</script>
@endsection
