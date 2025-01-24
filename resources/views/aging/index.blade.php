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
</style>
<div class="table-responsive neumorphic-container">
    <table id="AgingTable" class="table dt-responsive thin-horizontal-lines neumorphic-table" style="width:100%">
        <thead>
            <tr>
                <th style="text-align: center;">TEAM</th>
                <th style="text-align: center;">POLICY NO.</th>
                <th style="text-align: center;">ASSURED NAME</th>
                <th style="text-align: center;">SALE DATE</th>
                <th style="text-align: center; font-size:8px;">MODE OF <br> PAYMENT</th>
                <th style="text-align: center; ">DUE DATE</th>
                <th style="text-align: center;">TERMS</th>
                <th style="text-align: center; font-size:8px;"> GROSS PREMIUM <br> (NET OF DISCOUNTS)</th>
                <th style="text-align: center; font-size:8px;">TOTAL <br> OUTSTANDING</th>
                <th style="text-align: center;">BALANCE</th>
                <th style="text-align: center;">AGE</th>
                <th style="text-align: center; font-size:10px;">AGING DUE</th>
                <th style="text-align: center;">AGING DESCRIPTION</th>
                <th style="text-align: center;"> ACTION </th>
            </tr>
        </thead>
        <tbody>
            <!-- Table rows will be dynamically inserted here -->
        </tbody>
    </table>
</div>
<!-- Modal for Viewing and Editing Pivot Details -->
<div class="modal fade" id="viewPivotDetailsModal" tabindex="-1" aria-labelledby="viewPivotDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewPivotDetailsModalLabel">Aging Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editPivotForm">
                    <div class="mb-3" hidden>
                        <label for="pivotIdInput" class="form-label"><strong>ID:</strong></label>
                        <input type="text" class="form-control" id="pivotIdInput" name="id" readonly>
                    </div>
                    <div class="row mb-3 align-items-center">
                        <div class="col-md-6">
                            <label for="pivotPaidAmountInput" class="form-label"><strong>Paid Amount:</strong></label>
                            <input type="text" class="form-control" id="pivotPaidAmountInput" name="paid_amount">
                        </div>
                        <div class="col-md-6">
                            <label for="pivotPaidScheduleInput" class="form-label"><strong>Paid Schedule:</strong></label>
                            <input type="text" class="form-control" id="pivotPaidScheduleInput" name="paid_schedule">
                        </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                        <div class="col-md-6">
                            <label for="pivotPaymentAmountInput" class="form-label"><strong>Payment Amount:</strong></label>
                            <input type="text" class="form-control" id="pivotPaymentAmountInput" name="payment_amount" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="pivotPaymentScheduleInput" class="form-label"><strong>Payment Schedule:</strong></label>
                            <input type="text" class="form-control" id="pivotPaymentScheduleInput" name="payment_schedule" readonly>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                        <div class="col-md-4">
                            <label for="pivotOverUnderPaymentInput" class="form-label"><strong>Over/Under Payment:</strong></label>
                            <input type="text" class="form-control" id="pivotOverUnderPaymentInput" name="over_under_payment" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="pivotReferenceNumberInput" class="form-label"><strong>Reference Number:</strong></label>
                            <input type="text" class="form-control" id="pivotReferenceNumberInput" name="reference_number">
                        </div>
                        <div class="col-md-4">
                            <label for="pivotPaidInput" class="form-label"><strong>Paid:</strong></label>
                            <select class="form-control" id="pivotPaidInput" name="paid">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    <div class="mb-3 " id="raRemarksContainer">
                        <label for="pivotRaRemarksInput" class="form-label me-2"><strong>RA Remarks:</strong></label>
                            <div class="d-flex align-items-center">
                                <textarea class="form-control me-2" id="pivotRaRemarksInput" name="ra_remarks" rows="2" readonly></textarea>
                                <button type="button" id="addNewRaRemarks" class="btn btn-secondary">Add Remarks</button>
                            </div>          
                    </div>
                    
                    <div id="newRaRemarksInput" style="display: none;">
                        <label for="pivotNewRaRemarksInput" class="form-label"><strong>Add RA Remarks:</strong></label>
                            <div class="d-flex align-items-center">
                                <textarea class="form-control me-2" id="pivotNewRaRemarksInput" name="ra_remarks" rows="2"></textarea>
                                <button type="button" id="cancelNewRaRemarks" class="btn btn-secondary mt-2">Cancel</button>
                            </div>                        
                    </div>
                    <div id = "teleRemarksContainer" class="mb-3">
                        <label for="pivotTeleRemarksInput" class="form-label"><strong>Tele Remarks:</strong></label>
                        <div class="d-flex align-items-center">
                            <textarea class="form-control me-2" id="pivotTeleRemarksInput" name="tele_remarks" rows="2"></textarea>
                            <button type="button" id="addNewTeleRemarks" class="btn btn-secondary mt-2">Add Remarks</button>
                        </div>
                    </div>
                    <div id="newTeleRemarksInput" style="display: none;">
                        <label for="pivotNewTeleRemarksInput" class="form-label"><strong>Add Tele Remarks:</strong></label>
                        <div class="d-flex align-items-center">
                            <textarea class="form-control me-2" id="pivotNewTeleRemarksInput" name="tele-remarks" rows="2"></textarea>
                            <button type="button" id="cancelNewTeleRemarks" class="btn btn-secondary mt-2">Cancel</button>
                        </div> 
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button id="savePivotDetailsBtn" class="btn btn-primary">Save</button>
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
            order: [[0, 'asc']], // Default sorting on the first column
            dom: '<"row TOP-ROW"<"col-md-6 MASTER-LIST"><"col-md-6 pb-3 SEARCHING "f>>t<"row"<"col-md-6 pt-3"l><"col-md-6 pt-2"p>>',
            initComplete: function () {
                // Add the header to the MASTER-LIST column
                $('.MASTER-LIST').html('<h1><span style="color: #FF3832;"><b>AR</b></span> Aging</h1>');

                // Wrap the search field and button in a flex container
                $('.SEARCHING').addClass('d-flex align-items-center justify-content-end');
            },

            columns: [
                { data: 'team', className: 'text-center' },
                { data: 'policy_number', className: 'text-center' },
                { data: 'name', className: 'text-center' },
                {
                    data: 'sale_date',
                    className: 'text-center',
                    render: function (data) {
                        if (data) {
                            const saleDate = new Date(data);
                            return saleDate.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                        }
                        return 'Invalid date';
                    }
                },
                { data: 'mode_of_payment', className: 'text-center' },
                {
                    data: null, // Use null since we will access multiple fields
                    className: 'text-center',
                    render: function (data) {
                        const startDate = data.due_date_start ? new Date(data.due_date_start) : null;
                        const endDate = data.due_date_end ? new Date(data.due_date_end) : null;

                        if (startDate && endDate) {
                            const formattedStartDate = startDate.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                            const formattedEndDate = endDate.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                            return `${formattedStartDate} to <br>${formattedEndDate}`;
                        } else {
                            return 'Invalid date range';
                        }
                    }
                },
                { data: 'terms', className: 'text-center' },
                {
                    data: 'gross_premium',
                    className: 'text-center',
                    render: function (data) {
                        return data
                            ? data.toLocaleString('en-US', { style: 'currency', currency: 'USD' })
                            : '$0.00';
                    }
                },
                {
                    data: 'total_outstanding',
                    className: 'text-center',
                    render: function (data) {
                        return data
                            ? data.toLocaleString('en-US', { style: 'currency', currency: 'USD' })
                            : '$0.00';
                    }
                },
                {
                    data: 'balance',
                    className: 'text-center',
                    render: function (data) {
                        return data
                            ? data.toLocaleString('en-US', { style: 'currency', currency: 'USD' })
                            : '$0.00';
                    }
                },
                {
                    data: 'days_of_age',
                    className: 'text-center',
                    render: function (data) {
                        return data ? `${data} days` : 'N/A'; // Show "N/A" if the data is null or undefined
                    }
                },
                {
                    data: 'aging_due_days',
                    className: 'text-center'
                },
                {
                    data: 'aging_description',
                    className: 'text-center'
                },
                {
                    data: 'action',
                    className: 'text-center',
                    orderable: false,
                    render: function (data, type, row) {
                        return `
                            <button class="btn btn-primary btn-sm details-btn" data-id="${row.id}">
                                Details
                            </button>
                        `;
                    }
                }
            ]
        });


        // Fetch data using $.ajax
        function fetchTableData() {
            $.ajax({
                url: '/api/aging-data', // Your API endpoint
                method: 'GET',
                success: function (data) {
                    table.clear();
                    table.rows.add(data).draw();
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        }

        // Fetch data on page load
        fetchTableData();

        // Expandable row functionality
        $(document).on('click', '.details-btn', function () {
            const id = $(this).data('id');
            const row = table.row($(this).closest('tr'));
            const rowData = row.data();

            if (!rowData) {
                return;
            }

            // Toggle row details
            if (row.child.isShown()) {
                row.child.hide();
                $(this).removeClass('shown');
            } else {
                row.child(formatRowDetails(rowData)).show();
                $(this).addClass('shown');
                fetchArAgingPivots(id);
            }
        });


        // Function to format the details for the expandable row
        function formatRowDetails(data) {
            return `
                <div id="ar-aging-pivots-${data.id}">
                    <p>Loading AR Aging Pivots...</p>
                </div>
            `;
        }

        // Fetch AR Aging Pivots details
        function fetchArAgingPivots(id) {
            $.ajax({
                url: `/api/ar-aging-pivots/${id}`, // Your API endpoint for AR Aging Pivots
                method: 'GET',
                success: function (data) {
                    // Log the summary for debugging
                    console.log('Summary:', data.summary);

                    if (data.pivots && data.pivots.length > 0) {
                        const tableHtml = `
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        ${data.pivots.map(pivot => `<th style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 150px;">${pivot.label}</th>`).join('')}
                                        <th style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 150px;">Total</th> <!-- Add Total column here -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        ${data.pivots.map(pivot => `
                                            <td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 150px;">
                                                <div><strong>Paid Amount:</strong> ${pivot.paid_amount
                                                    ? pivot.paid_amount.toLocaleString('en-US', { style: 'currency', currency: 'PHP' })
                                                    : ' '}</div>
                                                <div><strong>Paid Schedule:</strong> ${pivot.paid_schedule || ' '}</div>
                                                <div><strong>Payment Amount:</strong> ${pivot.payment_amount
                                                    ? pivot.payment_amount.toLocaleString('en-US', { style: 'currency', currency: 'PHP' })
                                                    : ' '}</div>
                                                <div><strong>Payment Schedule:</strong> ${pivot.payment_schedule || ' '}</div>
                                                <div><strong>Over/Under Payment:</strong> ${pivot.over_under_payment
                                                    ? pivot.over_under_payment.toLocaleString('en-US', { style: 'currency', currency: 'PHP' })
                                                    : ' '}</div>
                                                <div><strong>Reference Number:</strong> ${pivot.reference_number || ' '}</div>
                                                <div><strong>RA Remarks:</strong> ${pivot.ra_remarks || ' '}</div>
                                                <div><strong>Tele Remarks:</strong> ${pivot.tele_remarks || ' '}</div>
                                                <div><strong>Paid:</strong> ${pivot.paid ? 'Yes' : ' '}</div>
                                                <!-- View Details Button -->
                                                <div> ${((pivot.paid_amount / data.summary.gross_premium) * 100).toFixed(2) + '%'}</div>
                                                <button 
                                                    class="btn btn-primary btn-sm mt-2 view-details-btn" 
                                                    data-id="${pivot.id}" 
                                                    data-pivot='${JSON.stringify(pivot).replace(/"/g, '&quot;')}' 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#viewPivotDetailsModal">
                                                    View Details
                                                </button>
                                            </td>
                                        `).join('')}
                                        <td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 150px;">
                                            <div><strong>Gross Premium:</strong> ${
                                                data.summary.gross_premium
                                            }</div>
                                            <div><strong>Total Paid:</strong> ${
                                                data.totalPaidAmount
                                            }</div>
                                            <div><strong>Percentage Paid:</strong> ${
                                                ((data.totalPaidAmount / data.summary.gross_premium) * 100).toFixed(2) + '%'
                                            }</div>
                                            <div><strong>Total Over/Under Payment:</strong> ${
                                                data.totalOverUnderPayment}
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        `;

                        $(`#ar-aging-pivots-${id}`).html(tableHtml);

                        // Bind the click event for the View Details buttons
                        document.querySelectorAll('.view-details-btn').forEach(button => {
                            button.addEventListener('click', function () {
                                const pivot = JSON.parse(button.getAttribute('data-pivot'));
                                populateModalDetails(pivot);
                            });
                        });
                    } else {
                        $(`#ar-aging-pivots-${id}`).html('<p>No AR Aging Pivots available.</p>');
                    }
                },
                error: function (xhr, status, error) {
                    $(`#ar-aging-pivots-${id}`).html('<p>Error loading details.</p>');
                    console.error('Error fetching AR Aging Pivots:', error);
                }
            });
        }


        function populateModalDetails(pivot) {
            $('#pivotIdInput').val(pivot.id); // Set the ID dynamically
            $('#pivotLabelInput').val(pivot.label || '');
            $('#pivotPaidAmountInput').val(pivot.paid_amount || '');
            $('#pivotPaidScheduleInput').val(pivot.paid_schedule || ''); // Ensure input starts as blank
            $('#pivotPaymentAmountInput').val(pivot.payment_amount || '');
            $('#pivotPaymentScheduleInput').val(pivot.payment_schedule || '');
            $('#pivotReferenceNumberInput').val(pivot.reference_number || '');
            $('#pivotRaRemarksInput').val(pivot.ra_remarks || '');
            $('#pivotTeleRemarksInput').val(pivot.tele_remarks || '');
            $('#pivotPaidInput').val(pivot.paid ? '1' : '0');

            // Calculate over_under_payment
            calculateOverUnderPayment();

            // Initialize DateRangePicker when modal is shown
            $('#viewPivotDetailsModal').on('shown.bs.modal', function() {
                $('#pivotPaidScheduleInput').daterangepicker({
                    singleDatePicker: true,  // Enable single date selection
                    showDropdowns: true,    // Show year and month dropdowns
                    autoUpdateInput: false, // Don't update input field automatically
                    locale: {
                        format: 'MM/DD/YYYY', // Set the date format to MM/DD/YYYY
                    },
                }).on('apply.daterangepicker', function(ev, picker) {
                    // Manually set the selected date to the input field
                    $('#pivotPaidScheduleInput').val(picker.startDate.format('MM/DD/YYYY'));
                });
            });

            // Add event listeners for changes in paid_amount or payment_amount to recalculate over_under_payment
            $('#pivotPaidAmountInput, #pivotPaymentAmountInput').on('input', function() {
                calculateOverUnderPayment();
            });

            // Clear RA remarks field when clicked
            $('#addNewRaRemarks').on('click', function() {
                // $(this).val(''); // Clear the 'RA Remarks' field

                // Hide the original RA Remarks container and show the new remarks container
                $('#raRemarksContainer').hide();
                $('#newRaRemarksInput').show();
            });

            // When the 'Cancel' button is clicked in the new remarks section
            $('#cancelNewRaRemarks').on('click', function() {
                // Hide the new remarks container and show the original RA Remarks container
                $('#newRaRemarksInput').hide();
                $('#raRemarksContainer').show();

                // Optionally, clear the new remarks input field
                $('#pivotNewRaRemarksInput').val('');
            });
            // Clear other fields if required (Example for Tele Remarks)

            //--------
            $('#addNewTeleRemarks').on('click', function() {
                // $(this).val(''); // Clear the 'RA Remarks' field

                // Hide the original RA Remarks container and show the new remarks container
                $('#teleRemarksContainer').hide();
                $('#newTeleRemarksInput').show();
            });

            // When the 'Cancel' button is clicked in the new remarks section
            $('#cancelNewTeleRemarks').on('click', function() {
                // Hide the new remarks container and show the original RA Remarks container
                $('#newTeleRemarksInput').hide();
                $('#teleRemarksContainer').show();

                // Optionally, clear the new remarks input field
                $('#pivotNewTeleRemarksInput').val('');
            });
            // Clear other fields if required (Example for Tele Remarks)

            
        }

        // Function to calculate over_under_payment
        function calculateOverUnderPayment() {
            const paidAmount = parseFloat($('#pivotPaidAmountInput').val()) || 0;
            const paymentAmount = parseFloat($('#pivotPaymentAmountInput').val()) || 0;

            const overUnderPayment = paidAmount - paymentAmount;

            // Display the result in the over_under_payment field
            $('#pivotOverUnderPaymentInput').val(overUnderPayment);
        }

        // Function to save the data via PUT AJAX request
        function savePivotDetails() {
            // Get values from the modal inputs
            var pivotData = {
                id: $('#pivotIdInput').val(),
                label: $('#pivotLabelInput').val(),
                paid_amount: $('#pivotPaidAmountInput').val(),
                paid_schedule: $('#pivotPaidScheduleInput').val(),
                payment_amount: $('#pivotPaymentAmountInput').val(),
                payment_schedule: $('#pivotPaymentScheduleInput').val(),
                reference_number: $('#pivotReferenceNumberInput').val(),
                new_ra_remarks: $('#pivotNewRaRemarksInput').val(), // Send the value of the new RA remarks
                new_tele_remarks: $('#pivotNewTeleRemarksInput').val(), // Send the value of the new RA remarks

                // tele_remarks: $('#pivotTeleRemarksInput').val(),
                paid: $('#pivotPaidInput').val() === '1', // Ensure this is a boolean (true or false)
                over_under_payment: $('#pivotOverUnderPaymentInput').val() // Add over_under_payment
            };

            // Log the pivotData being sent
            console.log('Sending the following pivot data:', pivotData);

            // Send data to server via AJAX (PUT request)
            $.ajax({
                url: '/api/save-pivot-details/' + pivotData.id, // Correct URL to include the pivot ID
                method: 'PUT',
                data: pivotData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Add CSRF token to headers
                },
                success: function(response) {
                    // Log the response
                    console.log('Response from server:', response);

                    if (response.success) {
                        alert('Pivot details updated successfully!');
                        $('#viewPivotDetailsModal').modal('hide'); // Close the modal
                    } else {
                        alert('Error updating pivot details');
                    }
                    fetchTableData();
                },
                error: function(xhr, status, error) {
                    // Log the error details
                    console.error('AJAX error:', error);
                    console.error('XHR:', xhr);
                    console.error('Status:', status);
                    alert('Error updating pivot details');
                }
            });
        }

        // Attach save function to the "Save" button in the modal
        $('#savePivotDetailsBtn').on('click', function() {
            savePivotDetails();
        });


    });
</script>

@endsection
