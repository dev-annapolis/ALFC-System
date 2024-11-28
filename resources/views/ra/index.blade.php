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

    /* Show full details on hover */

</style>
<div class="container-fluid" style="max-height: 500px; overflow: auto;"> 
    <h2>Revenue Assistant Data</h2>
    <div class="table-responsive" style="max-width: 100%; overflow-x: auto; overflow-y: auto;"> 
        <table id="raTable" class="display nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>Issuance<br> Code</th>
                    <th>Name</th>
                    <th>Policy & <br>Plate Details</th>
                    <th>Mode of <br>Payment</th>
                    <th>PR Number</th>
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
<script>
    $(document).ready(function () {
        $('#raTable').DataTable({
            processing: true,
            serverSide: false, // Set to true if you want server-side processing
            ajax: {
                url: '/api/ra-index',
                type: 'GET',
                dataSrc: '' // Use this if the API response is a simple JSON array
            },
            columns: [
                { data: 'issuance_code' },
                { data: 'name' },
                {
                    data: null, // Combine policy_number and plate_conduction_number
                    render: function (data) {
                        const policyNumber = data.policy_number ?? 'N/A';
                        const plateNumber = data.plate_conduction_number ?? 'N/A';
                        return `
                            Policy Number: ${policyNumber}<br>
                            Plate/Conduction: ${plateNumber}
                        `;
                    }
                },
                { data: 'mode_of_payment' },
                { data: 'pr_number' },
                {
                    data: null, // Combine gross_premium, discount, and amount_due_to_provider
                    render: function (data) {
                        const grossPremium = data.gross_premium ?? 'N/A';
                        const discount = data.discount ?? 'N/A';
                        const amountDue = data.amount_due_to_provider ?? 'N/A';
                        return `
                            Gross Premium: ${grossPremium}<br>
                            Discount: ${discount}<br>
                            Amount Due: ${amountDue}
                        `;
                    }
                },
                {
                    data: null, // Combine sales_credit and sales_credit_percent
                    render: function (data) {
                        const credit = data.sales_credit ?? 'N/A';
                        const percent = data.sales_credit_percent ? `${data.sales_credit_percent}%` : 'N/A';
                        return `${credit} (${percent})`;
                    }
                },
                {
                    data: null, // Combine sale_date and date_of_good_as_sales
                    render: function (data) {
                        const saleDate = data.sale_date ?? 'N/A';
                        const goodAsSalesDate = data.date_of_good_as_sales ?? 'N/A';
                        return `
                            Sale Date: ${saleDate}<br>
                            Good as Sales Date: ${goodAsSalesDate}
                        `;
                    }
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
                render: function () {
                    return `
                        <div class="dropdown">
                             <button class="btn dropdown-toggle p-2 border-0 bg-transparent circular-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-ellipsis"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Action 1</a></li>
                                <li><a class="dropdown-item" href="#">Action 2</a></li>
                                <li><a class="dropdown-item" href="#">Action 3</a></li>
                            </ul>
                        </div>
                    `;
                }
            }
                
            

            ],
            responsive: true,
        });
    });
</script>
@endsection
