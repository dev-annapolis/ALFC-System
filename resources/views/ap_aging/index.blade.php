@extends('layouts.app')

@section('content')
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
    .highlight-row {
        background-color: #ffcccc !important; /* Light red background */
    }

    .cell-remittance-number {
    white-space: nowrap;  /* Prevent text from wrapping */
    overflow: hidden;     /* Hide overflowed text */
    text-overflow: ellipsis; /* Show ellipsis (...) for overflowed text */
    cursor: pointer;      /* Make the text clickable */
    max-width: 200px;      /* Set a fixed width for the cell */
}
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="table-responsive neumorphic-container">
    <table id="AgingTable" class="table dt-responsive thin-horizontal-lines neumorphic-table" style="width:100%">
        <thead>
            <tr>
                <th style="text-align: center;">ASSURED NAME</th>
                <th style="text-align: center;">PROVIDER</th>
                <th style="text-align: center;">REMMITANCE NO.</th>
                <th style="text-align: center;">POLICY NUMBER</th>
                <th style="text-align: center;">DUE DATE</th>
                <th style="text-align: center;">TERMS</th>     
                <th style="text-align: center;">DUE TO <br> PROVIDER</th>        
                <th style="text-align: center;">FIRST PAYMENT</th>
                <th style="text-align: center;">SECOND PAYMENT</th>
                <th style="text-align: center;">BALANCE</th>
                <th style="text-align: center;">TOTAL <br> OUTSTANDING</th>
                <th style="text-align: center;"> ACTION </th>
            </tr>
        </thead>
        <tbody>
            <!-- Table rows will be dynamically inserted here -->
        </tbody>
    </table>
</div>
<!-- Modal for updating record details -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update Aging Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateForm">
                    <input type="hidden" name="row_id" id="row_id">
                    <!-- Remittance Number (Editable) -->
                    <div class="mb-3">
                        <label for="due_to_provider" class="form-label">Due to Provider</label>
                        <input type="number" class="form-control" id="due_to_provider" name="due_to_provider" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="remittance_number" class="form-label">Remittance Number</label>
                        <textarea class="form-control" id="remittance_number" name="remittance_number" readonly></textarea>
                    </div>
                    
                    <!-- First Payment (Editable) -->
                    <div class="mb-3">
                        <label for="first_payment" class="form-label">First Payment</label>
                        <input type="number" class="form-control" id="first_payment" name="first_payment">
                    </div>
                    <!-- Second Payment (Editable) -->
                    <div class="mb-3">
                        <label for="second_payment" class="form-label">Second Payment</label>
                        <input type="number" class="form-control" id="second_payment" name="second_payment">
                    </div>
                    <!-- Due to Provider (Readonly) -->
                    
                    <!-- Balance (Readonly) -->
                    <div class="mb-3">
                        <label for="balance" class="form-label">Balance</label>
                        <input type="number" class="form-control" id="balance" name="balance" readonly>
                    </div>
                    <!-- Total Outstanding (Readonly) -->
                    <div class="mb-3">
                        <label for="total_outstanding" class="form-label">Total Outstanding</label>
                        <input type="number" class="form-control" id="total_outstanding" name="total_outstanding" readonly>
                    </div>
                    <button type="button" class="btn btn-primary" id="saveChangesBtn">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="remittanceModal" tabindex="-1" aria-labelledby="remittanceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="remittanceModalLabel">Remittance Number Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p id="remittanceText"></p>  <!-- Display remittance number here -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    $(document).ready(function () {
    // Initialize DataTable
    const table = $('#AgingTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: '/api/ap-aging-data', // Replace with the route to your apAgingData method
            method: 'GET',  // AJAX GET request
            dataSrc: function (json) {
                return json;  // Directly return the data from your backend
            }
        },
        order: [[0, 'asc']], // Default sorting on the first column
        dom: '<"row TOP-ROW"<"col-md-6 MASTER-LIST"><"col-md-6 pb-3 SEARCHING "f>>t<"row"<"col-md-6 pt-3"l><"col-md-6 pt-2"p>>',
        initComplete: function () {
            // Add the header to the MASTER-LIST column
            $('.MASTER-LIST').html('<h1><span style="color: #FF3832;"><b>AP</b></span> Aging</h1>');

            // Wrap the search field and button in a flex container
            $('.SEARCHING').addClass('d-flex align-items-center justify-content-end');
        },

        columns: [
            { data: 'assured_name', className: 'text-center' }, // Column 0: Assured Name
            { data: 'providers', className: 'text-center' },    // Column 1: Provider
            {
                data: 'remittance_number',
                className: 'text-center',
                
                createdCell: function (td, cellData, rowData, row, col) {
                    // Add the cell-specific class
                    $(td).addClass('cell-remittance-number');

                    // Add event listener to make the cell clickable
                    $(td).on('click', function() {
                        // Handle the click event and display the remittance number in the modal
                        $('#remittanceText').html(cellData.replace(/\n/g, '<br>')); // Replace line breaks with <br>
                        
                        // Show the modal
                        $('#remittanceModal').modal('show');
                    });
                }
            },     
            { data: 'policy_number', className: 'text-center' }, // Column 3: Policy Number
            {
                data: 'due_date_start',
                className: 'text-center',
                render: function (data, type, row) { // Column 4: Due Date
                    if (data && row.due_date_end) {
                        const startDate = new Date(data);
                        const endDate = new Date(row.due_date_end);
                        const formattedStartDate = startDate.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                        const formattedEndDate = endDate.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                        return `${formattedStartDate} to ${formattedEndDate}`;
                    }
                    return 'Invalid date';
                }
            },
            { data: 'terms', className: 'text-center' },        // Column 5: Terms
            {
                data: 'due_to_provider',
                className: 'text-center',
                render: function (data) {                         // Column 6: Due to Provider
                    return data ? data : 'N/A';
                }
            },
            {
                data: 'first_payment',
                className: 'text-center',
                render: function (data) {                         // Column 9: First Payment
                    return data ? data.toLocaleString('en-US', { style: 'currency', currency: 'PHP' }) : ' ';
                }
            },
            {
                data: 'second_payment',
                className: 'text-center',
                render: function (data) {                         // Column 10: Second Payment
                    return data ? data.toLocaleString('en-US', { style: 'currency', currency: 'PHP' }) : ' ';
                }
            },
            {
                data: 'balance',
                className: 'text-center',
                render: function (data) {                         // Column 8: Balance
                    return data ? data.toLocaleString('en-US', { style: 'currency', currency: 'PHP' }) : ' ';
                }
            },
           
            {
                data: 'total_outstanding',
                className: 'text-center',
                render: function (data) {                         // Column 7: Total Outstanding
                    return data ? data.toLocaleString('en-US', { style: 'currency', currency: 'PHP' }) : ' ';
                }
            },  
            {
                data: 'action',
                className: 'text-center',
                orderable: false,
                render: function (data, type, row) {              // Column 12: Action
                    return `
                        <button class="btn btn-primary btn-sm details-btn" data-id="${row.id}">
                            Details
                        </button>
                    `;
                }
            }
        ]

    });
    $(document).on('click', '.details-btn', function () {
        const rowId = $(this).data('id');  // Get the row ID from the button's data-id

        // Send an AJAX request to fetch all details based on the row ID
        $.ajax({
            url: '/api/aging-detail/' + rowId,  // Endpoint to fetch full details by ID
            method: 'GET',
            success: function (response) {
                if (response.success) {
                    const record = response.data;

                    // Populate the modal with the fetched data
                    $('#remittance_number').val(record.remittance_number);
                    $('#first_payment').val(record.first_payment);
                    $('#second_payment').val(record.second_payment);
                    $('#due_to_provider').val(record.due_to_provider);  // Populate due_to_provider (readonly)
                    $('#row_id').val(record.id);  // Store the row ID in the hidden input

                    // Compute the balance and total outstanding based on the new formula
                    const firstPayment = parseFloat(record.first_payment) || 0;
                    const secondPayment = parseFloat(record.second_payment) || 0;
                    const dueToProvider = parseFloat(record.due_to_provider) || 0;

                    // Calculate balance and total outstanding
                    const balance = dueToProvider - (firstPayment + secondPayment);
                    const totalOutstanding = firstPayment + secondPayment;

                    // Set the calculated values in the modal fields (readonly)
                    $('#balance').val(balance.toFixed(2));  // Updated balance
                    $('#total_outstanding').val(totalOutstanding.toFixed(2));  // Updated total outstanding

                    // Show the modal
                    $('#updateModal').modal('show');
                } else {
                    alert('Failed to fetch record details');
                }
            },
            error: function () {
                alert('Error fetching record details');
            }
        });
    });

    // Auto compute the balance and total outstanding when first payment or second payment changes
    $('#first_payment, #second_payment').on('input', function () {
        const firstPayment = parseFloat($('#first_payment').val()) || 0;
        const secondPayment = parseFloat($('#second_payment').val()) || 0;
        const dueToProvider = parseFloat($('#due_to_provider').val()) || 0;

        // Calculate balance and total outstanding
        const balance = dueToProvider - (firstPayment + secondPayment);
        const totalOutstanding = firstPayment + secondPayment;

        // Set the computed values in the modal fields (readonly)
        $('#balance').val(balance.toFixed(0));
        $('#total_outstanding').val(totalOutstanding.toFixed(0));
    });

    // Save changes when "Save changes" button is clicked
    $('#saveChangesBtn').on('click', function () {
        console.log('Save New Record button clicked');
        const id = $('#row_id').val();  // Ensure the ID is present in your form

        // Prompt the user for the remittance number
        let remittanceNumber = prompt("Enter the remittance number:");

        if (remittanceNumber === null || remittanceNumber === "") {
            alert("Remittance number is required!");
            return;  // Exit if remittance number is not provided
        }

        // Manually collect the values from the form fields
        const formData = {
            row_id: id,  // Include the id in the form data
            remittance_number: remittanceNumber,  // Send the remittance number
            first_payment: $('#first_payment').val(),
            second_payment: $('#second_payment').val(),
            balance: $('#balance').val(),
            total_outstanding: $('#total_outstanding').val(),
        };

        console.log('Form Data:', formData);

        const csrfToken = $('meta[name="csrf-token"]').attr('content');  // CSRF token for security

        // Send the data to the server to save the new record
        $.ajax({
            url: '/api/save-ap-aging/' + id,  // Include the dynamic 'id' in the URL
            method: 'POST',
            data: formData,  // Send form data as an object
            headers: {
                'X-CSRF-TOKEN': csrfToken  // Add the CSRF token to the request headers
            },
            success: function (response) {
                console.log('Server Response:', response);

                if (response.success) {
                    console.log('Record saved successfully');

                    // Close the modal
                    $('#updateModal').modal('hide');
                    console.log('Modal closed');

                    // Reload the DataTable to reflect the new record
                    table.ajax.reload();
                    console.log('DataTable reloaded');
                } else {
                    console.log('Failed to save the record');
                    alert('Failed to save the record');
                }
            },
            error: function (xhr, status, error) {
                console.log('AJAX Error:', status, error);
                alert('Error saving the record');
            }
        });
    });
});

</script>

@endsection