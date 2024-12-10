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
        <div class="col-md-6 SUBPRODUCT-MASTERLIST">
            <h1 class="fs-2 fw-medium">Master List of <strong>Sub-Products</strong></h1>
        </div>
        <div class="col-md-6 SEARCHING d-flex align-items-center justify-content-end">
            <!-- Add SubProduct Button -->
            <button class="btn btn-sm btn-primary fs-6 pe-3 me-3" data-bs-toggle="modal" data-bs-target="#addSubProductsModal">
                <i class="me-2 ms-2 fa-solid fa-plus"></i>
                Add Sub-Products
            </button>
            <!-- Search box will be initialized by DataTables -->
        </div>
    </div>

    <div class="table-container">

        <div class="table-responsive">
            <table class="table dt-responsive shadow-sm " id="subProductsTable">
                <thead class="fw-medium">
                    <tr class="fs-6">
                        <th style="width: 33%;">Name</th>
                        <th style="width: 33%;">Status</th>
                        <th style="width: 33%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subproducts as $subproduct)
                        <tr class="fs-6 shadow-sm">
                            <td class="text-secondary fw-medium">{{ $subproduct->name }}</td>
                            <td>
                                <span class="badge {{ $subproduct->status === 'active' ? 'bg-active' : 'bg-inactive' }}">
                                    {{ ucfirst($subproduct->status) }}
                                </span>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('subproducts.changeStatus', $subproduct->id) }}" class="d-inline" >
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-change-status btn-sm">Change Status</button>
                                </form>

                                <button
                                class="btn btn-edit btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#editSubProductModal"
                                data-id="{{ $subproduct->id }}"
                                data-name="{{ $subproduct->name }}"
                                data-product-id="{{ $subproduct->product_id }}"
                                style="margin-left: 0.5rem;"
                            >
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

<!-- Add Sub Product Modal -->
<div class="modal fade" id="addSubProductsModal" tabindex="-1" aria-labelledby="addSubProductsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('subproducts.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSubProductsModalLabel">Add Sub-Products</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="productSelect" class="form-label">Select Product</label>
                        <select class="form-select" id="productSelect" name="product_id" required>
                            <option value="" disabled selected>Select a product</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="subProductName" class="form-label">Sub-Product Name</label>
                        <input type="text" class="form-control" id="subProductName" name="name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Sub-Product</button>
                </div>
            </div>
        </form>
    </div>
</div>




<!-- Edit Sub-Products Modal -->
<div class="modal fade" id="editSubProductModal" tabindex="-1" aria-labelledby="editSubProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('subproducts.update') }}">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSubProductModalLabel">Edit Sub-Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editSubProductId" name="id">

                    <!-- Product Dropdown -->
                    <div class="mb-3">
                        <label for="editProductSelect" class="form-label">Select Product</label>
                        <select class="form-select" id="editProductSelect" name="product_id" required>
                            <option value="" disabled>Select a product</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sub-Product Name -->
                    <div class="mb-3">
                        <label for="editSubProductName" class="form-label">Sub-Product Name</label>
                        <input type="text" class="form-control" id="editSubProductName" name="name" required>
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

        // Show the success alert if it's present
        var successAlert = document.getElementById('success-alert');
        if (successAlert) {
            successAlert.style.display = 'block';  // Make alert visible
            setTimeout(function() {
                successAlert.classList.remove('show');
                successAlert.classList.add('fade');
            }, 1075);  // 1 second delay before fading out
        }


        var table = $('#subProductsTable').DataTable({
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
        searchBox.find('input').addClass('form-control').attr('placeholder', 'Search Sub-Products').css('width', '100%');


        // Handle Edit Button Click
        document.getElementById('editSubProductModal').addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var name = button.getAttribute('data-name');
            var productId = button.getAttribute('data-product-id');

            document.getElementById('editSubProductId').value = id;
            document.getElementById('editSubProductName').value = name;

            // Set the selected product in the dropdown
            var productSelect = document.getElementById('editProductSelect');
            Array.from(productSelect.options).forEach(option => {
                option.selected = option.value == productId;
            });
        });

    });
</script>


@endsection
