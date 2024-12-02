@extends('layouts.app')

@section('content')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

<style>
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
    

</style>
<div class="container-fluid" style=" overflow: auto;"> 
    
    
    <h2>Revenue Assistant Data</h2>
    <div class="table-responsive" style="width: 100%; overflow-x: auto; overflow-y: auto;"> 
        <div class="dropdown mb-3">
            <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Filter by Teams
            </button>
            <div class="dropdown-menu p-3">
                @foreach($teams as $team)
                <div class="form-check">
                    <input 
                        type="checkbox" 
                        class="form-check-input team-filter" 
                        value="{{ $team->id }}" 
                        id="team_{{ $team->id }}"
                    />
                    <label class="form-check-label" for="team_{{ $team->id }}">{{ $team->name }}</label>
                </div>
                @endforeach
                <button id="applyFilter" class="btn btn-success mt-3 w-100">Apply Filter</button>
            </div>
        </div>
        <table id="raTable" class="display nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>Issuance<br> Code</th>
                    <th>Name</th>
                    <th>Policy & <br>Plate Details<br>PR Number</th>
                    <th>Mode of <br>Payment</th>
                    <th>SA&<br>Team</th>
                    <th>Premium Details <br>(Gross, Discount, Amount Due)</th>
                    <th>Sales Credit <br>(Amount & Percent)</th>
                    <th>Sale Dates <br>(Sale Date & Good as Sales)</th>
                    <th>Status</th>
                    <th>RA Comments</th>    
                    <th>Actions</th>    
                </tr>
            </thead>
            <tbody>
                
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
        serverSide: true,
        ajax: {
            url: '/api/ra-index',
            type: 'GET',
            data: function (d) {
                d.team_ids = getSelectedTeamIds(); // Send selected team IDs
            },
        },
        columns: [
            { data: 'issuance_code' },
            { data: 'name' },
            {
                data: null,
                render: function (data) {
                    const policyNumber = data.policy_number ?? 'N/A';
                    const plateNumber = data.plate_conduction_number ?? 'N/A';
                    const prNumber = data.pr_number ?? 'N/A';
                    return `Policy Number: ${policyNumber}<br>Plate/Conduction: ${plateNumber}<br>PR Number: ${prNumber}`;
                },
            },
            { data: 'mode_of_payment' },
            {
                data: null,
                render: function (data) {
                    const salesAssociate = data.sales_associate ?? 'N/A';
                    const team = data.sales_team ?? 'N/A';
                    return `${salesAssociate}<br> ${team}`;
                },
            },
            {
                data: null,
                render: function (data) {
                    const grossPremium = data.gross_premium ?? 'N/A';
                    const discount = data.discount ?? 'N/A';
                    const amountDue = data.amount_due_to_provider ?? 'N/A';
                    return `Gross Premium: ${grossPremium}<br>Discount: ${discount}<br>Amount Due: ${amountDue}`;
                },
            },
            {
                data: null,
                render: function (data) {
                    const credit = data.sales_credit ?? 'N/A';
                    const percent = data.sales_credit_percent ? `${data.sales_credit_percent}%` : 'N/A';
                    return `${credit} (${percent})`;
                },
            },
            {
                data: null,
                render: function (data) {
                    const saleDate = data.sale_date ?? 'N/A';
                    const goodAsSalesDate = data.date_of_good_as_sales ?? 'N/A';
                    return `Sale Date: ${saleDate}<br>Good as Sales Date: ${goodAsSalesDate}`;
                },
            },
            { data: 'status' },
            {
                data: 'ra_comments',
                createdCell: function (td, cellData) {
                    $(td).addClass('nowrap-ellipsis');
                    $(td).attr('title', cellData); 
                    $(td).on('click', function() {
                        $('#commentText').text(cellData); 
                        $('#commentModal').modal('show');
                    });
                }
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
                }
            }
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
            <td contenteditable="true" class="commissioner-name">New Name</td>
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
                console.log(teamIds);
            });
            return teamIds.length > 0 ? teamIds : null; // Return null if no teams selected
        }

        // Reload DataTable when Apply Filter is clicked
        $('#applyFilter').on('click', function () {
            table.ajax.reload();
        });
    });


</script>
@endsection
