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
        <div class="col-md-6 ASSURED-MASTERLIST">
            <h1 class="fs-2 fw-medium">Master List of <strong>Assured Details</strong></h1>
        </div>
        <div class="col-md-6 SEARCHING d-flex align-items-center justify-content-end">
            <!-- Add Assured Detail Button -->
            <button class="btn btn-sm btn-primary fs-6 pe-3 me-3" data-bs-toggle="modal" data-bs-target="#addAssuredDetailModal">
                <i class="me-2 ms-2 fa-solid fa-plus"></i>
                Add Assured Detail
            </button>
        </div>
    </div>

    <div class="table-container">
        <div class="table-responsive">
            <table class="table dt-responsive shadow-sm" id="assuredDetailsTable">
                <thead class="fw-medium">
                    <tr class="fs-6">
                        <th style="width: 10%;">Name</th>
                        <th style="width: 15%;">Address</th>
                        <th style="width: 20%;">Contact Numbers</th>
                        <th style="width: 20%;">Email</th>
                        <th style="width: 20%;">Business</th>

                        <th style="width: 20%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($assuredDetails as $assuredDetail)
                        <tr class="fs-6 shadow-sm">
                            <td class="text-secondary fw-medium">{{ $assuredDetail->name }}</td>
                            <td class="text-secondary">
                                {{ $assuredDetail->lot_number }} {{ $assuredDetail->street }}<br>
                                {{ $assuredDetail->barangay }} {{ $assuredDetail->city }}<br>
                                {{ $assuredDetail->country }}
                            </td>
                            <td class="text-secondary">
                                <strong>Primary Contact:</strong> {{ $assuredDetail->contact_number }}<br>
                                <strong>Other Contact:</strong> {{ $assuredDetail->other_contact_number }}<br>
                                <strong>Viber:</strong> {{ $assuredDetail->viber_account }}
                            </td>
                            <td class="text-secondary">
                                <strong>Email</strong> {{ $assuredDetail->email }}<br>
                                <strong>Facebook:</strong> {{ $assuredDetail->facebook_account }}<br>
                            </td>
                            <td class="text-secondary">
                                <strong>Nature of Business:</strong> {{ $assuredDetail->nature_of_business }}<br>
                                <strong>Other Assets:</strong> {{ $assuredDetail->other_assets }}<br>
                                <strong>Other Source of Business:</strong> {{ $assuredDetail->other_source_of_business }}
                            </td>
                            <td>
                                <button class="btn btn-edit btn-sm" data-bs-toggle="modal" data-bs-target="#editAssuredDetailModal"
                                    data-id="{{ $assuredDetail->id }}"
                                    data-name="{{ $assuredDetail->name }}"
                                    data-lot_number="{{ $assuredDetail->lot_number }}"
                                    data-street="{{ $assuredDetail->street }}"
                                    data-barangay="{{ $assuredDetail->barangay }}"
                                    data-city="{{ $assuredDetail->city }}"
                                    data-country="{{ $assuredDetail->country }}"
                                    data-contact_number="{{ $assuredDetail->contact_number }}"
                                    data-other_contact_number="{{ $assuredDetail->other_contact_number }}"
                                    data-email="{{ $assuredDetail->email }}"
                                    data-facebook_account="{{ $assuredDetail->facebook_account }}"
                                    data-viber_account="{{ $assuredDetail->viber_account }}"
                                    data-nature_of_business="{{ $assuredDetail->nature_of_business }}"
                                    data-other_assets="{{ $assuredDetail->other_assets }}"
                                    data-other_source_of_business="{{ $assuredDetail->other_source_of_business }}">
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

<!-- Add Assured Detail Modal -->
<div class="modal fade" id="addAssuredDetailModal" tabindex="-1" aria-labelledby="addAssuredDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('assured_details.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAssuredDetailModalLabel">Add Assured Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="assuredDetailName" class="form-label">Assured Name</label>
                        <input type="text" class="form-control" id="assuredDetailName" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="lot_number" class="form-label">Lot Number</label>
                        <input type="text" class="form-control" id="lot_number" name="lot_number" maxlength="255">
                    </div>

                    <div class="mb-3">
                        <label for="street" class="form-label">Street</label>
                        <input type="text" class="form-control" id="street" name="street" maxlength="255">
                    </div>

                    <div class="mb-3">
                        <label for="barangay" class="form-label">Barangay</label>
                        <input type="text" class="form-control" id="barangay" name="barangay" maxlength="255">
                    </div>

                    <div class="mb-3">
                        <label for="city" class="form-label">City</label>
                        <input type="text" class="form-control" id="city" name="city" maxlength="255">
                    </div>

                    <div class="mb-3">
                        <label for="country" class="form-label">Country</label>
                        <input type="text" class="form-control" id="country" name="country" maxlength="255">
                    </div>

                    <div class="mb-3">
                        <label for="contact_number" class="form-label">Contact Number</label>
                        <input type="text" class="form-control" id="contact_number" name="contact_number" maxlength="20">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" maxlength="255">
                    </div>

                    <div class="mb-3">
                        <label for="other_contact_number" class="form-label">Other Contact Number</label>
                        <input type="text" class="form-control" id="other_contact_number" name="other_contact_number" maxlength="20">
                    </div>

                    <div class="mb-3">
                        <label for="facebook_account" class="form-label">Facebook Account</label>
                        <input type="text" class="form-control" id="facebook_account" name="facebook_account" maxlength="255">
                    </div>

                    <div class="mb-3">
                        <label for="viber_account" class="form-label">Viber Account</label>
                        <input type="text" class="form-control" id="viber_account" name="viber_account" maxlength="255">
                    </div>

                    <div class="mb-3">
                        <label for="nature_of_business" class="form-label">Nature of Business</label>
                        <input type="text" class="form-control" id="nature_of_business" name="nature_of_business" maxlength="255">
                    </div>

                    <div class="mb-3">
                        <label for="other_assets" class="form-label">Other Assets</label>
                        <input type="text" class="form-control" id="other_assets" name="other_assets" maxlength="255">
                    </div>

                    <div class="mb-3">
                        <label for="other_source_of_business" class="form-label">Other Source of Business</label>
                        <input type="text" class="form-control" id="other_source_of_business" name="other_source_of_business" maxlength="255">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Assured Detail</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Edit Assured Detail Modal -->
<div class="modal fade" id="editAssuredDetailModal" tabindex="-1" aria-labelledby="editAssuredDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('assured_details.update') }}">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAssuredDetailModalLabel">Edit Assured Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editAssuredDetailId" name="id">

                    <div class="mb-3">
                        <label for="editAssuredDetailName" class="form-label">Assured Name</label>
                        <input type="text" class="form-control" id="editAssuredDetailName" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="editLotNumber" class="form-label">Lot Number</label>
                        <input type="text" class="form-control" id="editLotNumber" name="lot_number" maxlength="255">
                    </div>

                    <div class="mb-3">
                        <label for="editStreet" class="form-label">Street</label>
                        <input type="text" class="form-control" id="editStreet" name="street" maxlength="255">
                    </div>

                    <div class="mb-3">
                        <label for="editBarangay" class="form-label">Barangay</label>
                        <input type="text" class="form-control" id="editBarangay" name="barangay" maxlength="255">
                    </div>

                    <div class="mb-3">
                        <label for="editCity" class="form-label">City</label>
                        <input type="text" class="form-control" id="editCity" name="city" maxlength="255">
                    </div>

                    <div class="mb-3">
                        <label for="editCountry" class="form-label">Country</label>
                        <input type="text" class="form-control" id="editCountry" name="country" maxlength="255">
                    </div>

                    <div class="mb-3">
                        <label for="editContactNumber" class="form-label">Contact Number</label>
                        <input type="text" class="form-control" id="editContactNumber" name="contact_number" maxlength="20">
                    </div>

                    <div class="mb-3">
                        <label for="editEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editEmail" name="email" maxlength="255">
                    </div>

                    <div class="mb-3">
                        <label for="editOtherContactNumber" class="form-label">Other Contact Number</label>
                        <input type="text" class="form-control" id="editOtherContactNumber" name="other_contact_number" maxlength="20">
                    </div>

                    <div class="mb-3">
                        <label for="editFacebookAccount" class="form-label">Facebook Account</label>
                        <input type="text" class="form-control" id="editFacebookAccount" name="facebook_account" maxlength="255">
                    </div>

                    <div class="mb-3">
                        <label for="editViberAccount" class="form-label">Viber Account</label>
                        <input type="text" class="form-control" id="editViberAccount" name="viber_account" maxlength="255">
                    </div>

                    <div class="mb-3">
                        <label for="editNatureOfBusiness" class="form-label">Nature of Business</label>
                        <input type="text" class="form-control" id="editNatureOfBusiness" name="nature_of_business" maxlength="255">
                    </div>

                    <div class="mb-3">
                        <label for="editOtherAssets" class="form-label">Other Assets</label>
                        <input type="text" class="form-control" id="editOtherAssets" name="other_assets" maxlength="255">
                    </div>

                    <div class="mb-3">
                        <label for="editOtherSourceOfBusiness" class="form-label">Other Source of Business</label>
                        <input type="text" class="form-control" id="editOtherSourceOfBusiness" name="other_source_of_business" maxlength="255">
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
            successAlert.style.display = 'block';
            setTimeout(function() {
                successAlert.classList.remove('show');
                successAlert.classList.add('fade');
                setTimeout(function() {
                    successAlert.style.display = 'none';
                }, 1500);
            }, 1075);
        }

        var table = $('#assuredDetailsTable').DataTable({
            paging: true,
            searching: true,
            info: false,
            order: [[0, 'asc']],
            pageLength: 10,
            lengthChange: false,
            columnDefs: [{ orderable: false, targets: [2] }],
            language: { search: "" }
        });

        var searchBox = $('div.dataTables_filter');
        searchBox.appendTo('.SEARCHING').css({ 'float': 'right', 'text-align': 'right' });
        searchBox.find('input').addClass('form-control').attr('placeholder', 'Search Assured Details').css('width', '100%');

        document.getElementById('editAssuredDetailModal').addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;

            // Extract data attributes
            document.getElementById('editAssuredDetailId').value = button.getAttribute('data-id');
            document.getElementById('editAssuredDetailName').value = button.getAttribute('data-name');
            document.getElementById('editLotNumber').value = button.getAttribute('data-lot_number');
            document.getElementById('editStreet').value = button.getAttribute('data-street');
            document.getElementById('editBarangay').value = button.getAttribute('data-barangay');
            document.getElementById('editCity').value = button.getAttribute('data-city');
            document.getElementById('editCountry').value = button.getAttribute('data-country');
            document.getElementById('editContactNumber').value = button.getAttribute('data-contact_number');
            document.getElementById('editOtherContactNumber').value = button.getAttribute('data-other_contact_number');
            document.getElementById('editEmail').value = button.getAttribute('data-email');
            document.getElementById('editFacebookAccount').value = button.getAttribute('data-facebook_account');
            document.getElementById('editViberAccount').value = button.getAttribute('data-viber_account');
            document.getElementById('editNatureOfBusiness').value = button.getAttribute('data-nature_of_business');
            document.getElementById('editOtherAssets').value = button.getAttribute('data-other_assets');
            document.getElementById('editOtherSourceOfBusiness').value = button.getAttribute('data-other_source_of_business');
        });

    });
</script>

@endsection
