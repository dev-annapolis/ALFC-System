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

</style>
<div class="table-responsive neumorphic-container">
    <table id="AgingTable" class="table table-striped dt-responsive thin-horizontal-lines neumorphic-table" style="width:100%">
        <thead>
            <tr>
                <th style="text-align: center;">TEAM</th>
                <th style="text-align: center;">POLICY NO.</th>
                <th style="text-align: center;">ASSURED NAME</th>
                <th style="text-align: center;">SALE DATE</th>
                <th style="text-align: center;">MODE OF PAYMENT</th>
                <th style="text-align: center;">DUE DATE</th>
                <th style="text-align: center;">TERMS</th>
                <th style="text-align: center;"> GROSS PREMIUM <br> (NET OF DISCOUNTS)</th>
                <th style="text-align: center;">BALANCE</th>
            </tr>
        </thead>
        <tbody>
            <!-- Table rows will be dynamically inserted here -->
        </tbody>
    </table>
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
                    data: 'due_date',
                    className: 'text-center',
                    render: function (data) {
                        if (data && data.includes(' to ')) {
                            const dueDate = data.split(' to ');
                            const startDate = new Date(dueDate[0]);
                            const endDate = new Date(dueDate[1]);
                            const formattedStartDate = startDate.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                            const formattedEndDate = endDate.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                            return `${formattedStartDate} to ${formattedEndDate}`;
                        }
                        return 'Invalid date range';
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
                    data: 'balance',
                    className: 'text-center',
                    render: function (data) {
                        return data
                            ? data.toLocaleString('en-US', { style: 'currency', currency: 'USD' })
                            : '$0.00';
                    }
                },
                
            ],
            
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
        $('#AgingTable tbody').on('click', 'tr', function () {
            const row = table.row(this);
            const rowData = row.data();

            if (!rowData) {
                console.error('Row data is undefined or null.');
                return;
            }

            // Check if the row is already expanded
            if (row.child.isShown()) {
                // If it's already shown, close it
                row.child.hide();
                $(this).removeClass('shown');
            } else {
                // If it's not shown, open it
                row.child(formatRowDetails(rowData)).show();
                $(this).addClass('shown');

                // Fetch AR Aging Pivots based on rowData.id
                fetchArAgingPivots(rowData.id);
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
                    if (data.length > 0) {
                        const tableHtml = `
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>Label</th>
                                        <th>Payment Amount</th>
                                        <th>Payment Schedule</th>
                                        <th>Paid Amount</th>
                                        <th>Paid Schedule</th>
                                        <th>Reference Number</th>
                                        <th>RA Remarks</th>
                                        <th>Tele Remarks</th>
                                        <th>Paid</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${data.map(pivot => `
                                        <tr>
                                            <td>${pivot.label}</td>
                                            <td>${pivot.payment_amount
                                                ? pivot.payment_amount.toLocaleString('en-US', { style: 'currency', currency: 'USD' })
                                                : '$0.00'}</td>
                                            <td>${pivot.payment_schedule || 'N/A'}</td>
                                            <td>${pivot.paid_amount
                                                ? pivot.paid_amount.toLocaleString('en-US', { style: 'currency', currency: 'USD' })
                                                : '$0.00'}</td>
                                            <td>${pivot.paid_schedule || 'N/A'}</td>
                                            <td>${pivot.reference_number || 'N/A'}</td>
                                            <td>${pivot.ra_remarks || 'N/A'}</td>
                                            <td>${pivot.tele_remarks || 'N/A'}</td>
                                            <td>${pivot.paid ? 'Yes' : 'No'}</td>
                                        </tr>
                                    `).join('')}
                                </tbody>
                            </table>
                        `;

                        $(`#ar-aging-pivots-${id}`).html(tableHtml);
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
    });
</script>




@endsection
