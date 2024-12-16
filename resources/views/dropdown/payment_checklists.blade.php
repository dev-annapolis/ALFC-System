@extends('layouts.app')
@section('content')

<style>
    .table-responsive {
        padding:0 auto;
        zoom: 90%; /* Adjust the zoom level as needed */

    }
    .table {
        margin-bottom: 0 !important;
        width: 100%;
        max-width: 100%;
        border: 2px solid #00000010;
        border-radius: 0.5rem;
    }


    .dataTables_paginate {
        margin-top: 1rem;
        margin-bottom: 1rem;

    }



    thead th {
        height: 2.5rem;
        border-top-radius: 100px;
        padding: 0.25rem;
        vertical-align: middle;
        background-color: rgba(239,245,252,255)!important;
        border-bottom: 2px solid #00000011!important;
        padding-top: 0.75rem !important;
        padding-bottom: 0.75rem !important;
        padding-left: 1rem !important;
        padding-right: 1rem !important;
        border-radius: 0.5rem 0.5rem 0 0;

    }

    .table > tbody > tr:first-child > td {
        padding-top: 1rem !important;
    }

    .table > tbody > tr:last-child > td {
        padding-bottom: 1rem !important;

    }

    .table td {
        padding-top: 0.5rem !important;
        padding-bottom: 0.4rem !important;
        padding-left: 1rem !important;
        padding-right: 1rem !important;
        border-bottom: 1px solid #8f8f8f1a!important;
    }

    table.dataTable.no-footer {
        border-bottom: 0!important;
    }





    .bg-active {
        background-color: #9be1b4 !important;
        color: #1a763e !important;
        padding-left: 1rem;
        padding-right: 1rem;
        vertical-align: middle;
        font-weight: bold !important;
    }

    .bg-inactive {
        background-color: #ff9999 !important;
        color: #973333 !important;
        padding-left: 0.75rem;
        padding-right: 0.75rem;
        vertical-align: middle;
    }

    .btn-change-status {
        background-color: rgb(238, 238, 238);
        border: 1px solid rgba(199, 199, 199, 0.651);
        color: rgb(100, 100, 100);
    }

    .btn-edit {
        background-color: #7e7e7e;
        width: 4rem;
        color: #ffffff;
    }

    #success-alert {
        position: fixed;
        top: 13%;
        left: 84%;
        transform: translate(-50%, -50%);
        z-index: 9999;
        display: none; /* Initially hidden */
        width: 25%;
    }

</style>





<div class="container-fluid p-5">
    @if (session('success'))
        <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row TOP-ROW mb-3">
        <div class="col-md-6 CHECKLIST-MASTERLIST">
            <h1 class="fs-2 fw-medium">Master List of <strong>Payment Checklists</strong></h1>
        </div>
        <div class="col-md-6 SEARCHING d-flex align-items-center justify-content-end">
            <!-- Add Payment Checklist Button -->
            <button class="btn btn-sm btn-primary fs-6 pe-3 me-3" data-bs-toggle="modal" data-bs-target="#addPaymentChecklistModal">
                <i class="me-2 ms-2 fa-solid fa-plus"></i>
                Add Payment Checklist
            </button>
            <!-- Search box will be initialized by DataTables -->
        </div>
    </div>

    <div class="table-container">

        <div class="table-responsive">
            <table class="table dt-responsive shadow-sm" id="paymentChecklistsTable">
                <thead class="fw-medium">
                    <tr class="fs-6">
                        <th style="width: 33%;">Name</th>
                        <th style="width: 33%;">Status</th>
                        <th style="width: 33%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paymentChecklists as $paymentChecklist)
                        <tr class="fs-6 shadow-sm">
                            <td class="text-secondary fw-medium">{{ $paymentChecklist->name }}</td>
                            <td>
                                <span class="badge {{ $paymentChecklist->status === 'active' ? 'bg-active' : 'bg-inactive' }}">
                                    {{ ucfirst($paymentChecklist->status) }}
                                </span>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('payment_checklists.changeStatus', $paymentChecklist->id) }}" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-change-status btn-sm">Change Status</button>
                                </form>

                                <button class="btn btn-edit btn-sm" data-bs-toggle="modal" data-bs-target="#editPaymentChecklistModal"
                                        data-id="{{ $paymentChecklist->id }}"
                                        data-name="{{ $paymentChecklist->name }}"
                                        data-mode-of-payment-id="{{ $paymentChecklist->mode_of_payment_id }}"
                                        style="margin-left: 0.5rem;">
                                    Edit
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

</div>

<!-- Add Payment Checklist Modal -->
<div class="modal fade" id="addPaymentChecklistModal" tabindex="-1" aria-labelledby="addPaymentChecklistModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('payment_checklists.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPaymentChecklistModalLabel">Add Payment Checklist</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="modeOfPaymentSelect" class="form-label">Select Mode of Payment</label>
                        <select class="form-select" id="modeOfPaymentSelect" name="mode_of_payment_id" required>
                            <option value="" disabled selected>Select a mode of payment</option>
                            @foreach($modesOfPayment as $modeOfPayment)
                                <option value="{{ $modeOfPayment->id }}">{{ $modeOfPayment->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="paymentChecklistName" class="form-label">Checklist Name</label>
                        <input type="text" class="form-control" id="paymentChecklistName" name="name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Payment Checklist</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Edit Payment Checklist Modal -->
<div class="modal fade" id="editPaymentChecklistModal" tabindex="-1" aria-labelledby="editPaymentChecklistModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('payment_checklists.update') }}">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPaymentChecklistModalLabel">Edit Payment Checklist</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editPaymentChecklistId" name="id">

                    <!-- Mode of Payment Dropdown -->
                    <div class="mb-3">
                        <label for="editModeOfPaymentSelect" class="form-label">Select Mode of Payment</label>
                        <select class="form-select" id="editModeOfPaymentSelect" name="mode_of_payment_id" required>
                            <option value="" disabled>Select a mode of payment</option>
                            @foreach($modesOfPayment as $modeOfPayment)
                                <option value="{{ $modeOfPayment->id }}">{{ $modeOfPayment->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Checklist Name -->
                    <div class="mb-3">
                        <label for="editPaymentChecklistName" class="form-label">Checklist Name</label>
                        <input type="text" class="form-control" id="editPaymentChecklistName" name="name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">

<script>
    document.addEventListener('DOMContentLoaded', function() {

        var successAlert = document.getElementById('success-alert');
        if (successAlert) {
            successAlert.style.display = 'block';  // Make alert visible
            setTimeout(function() {
                successAlert.classList.remove('show');
                successAlert.classList.add('fade');

                // Set a timeout for when the alert should be fully hidden
                setTimeout(function() {
                    successAlert.style.display = 'none'; // Hide the alert after fade
                }, 1500);  // Adjust the time (in ms) to match the fade-out duration
            }, 1075);  // 1 second delay before fading out
        }

        var table = $('#paymentChecklistsTable').DataTable({
            paging: true,
            searching: true, // Ensure search is enabled
            info: false,
            order: [[1, 'asc']],
            pageLength: 10,
            lengthChange: false, // Hide the "Show entries" dropdown
            columnDefs: [
                { orderable: false, targets: [2] } // Disable sorting on Actions column
            ],
            language: {
                search: "" // Remove "Search:" label by setting it to an empty string
            }
        });

        // .SEARCHING
        var searchBox = $('div.dataTables_filter');
        searchBox.appendTo('.SEARCHING').css({
            'float': 'right',
            'text-align': 'right'
        });
        searchBox.find('input').addClass('form-control').attr('placeholder', 'Search Payment Checklists').css('width', '100%');

        // Handle Edit Button Click
        document.getElementById('editPaymentChecklistModal').addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var name = button.getAttribute('data-name');
            var modeOfPaymentId = button.getAttribute('data-mode-of-payment-id');

            document.getElementById('editPaymentChecklistId').value = id;
            document.getElementById('editPaymentChecklistName').value = name;

            // Set the selected mode of payment in the dropdown
            var modeOfPaymentSelect = document.getElementById('editModeOfPaymentSelect');
            Array.from(modeOfPaymentSelect.options).forEach(option => {
                option.selected = option.value == modeOfPaymentId;
            });
        });

    });
</script>








@endsection
