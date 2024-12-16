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
        <div class="col-md-6 MASTERLIST">
            <h1 class="fs-2 fw-medium">Master List of <strong>Sales Managers</strong></h1>
        </div>
        <div class="col-md-6 SEARCHING d-flex align-items-center justify-content-end">
            <!-- Add Sales Manager Button -->
            <button class="btn btn-sm btn-primary fs-6 pe-3 me-3" data-bs-toggle="modal" data-bs-target="#addSalesManagerModal">
                <i class="me-2 ms-2 fa-solid fa-plus"></i>
                Add Sales Manager
            </button>
            <!-- Search box will be initialized by DataTables -->
        </div>
    </div>

    <div class="table-container">

        <div class="table-responsive">
            <table class="table dt-responsive shadow-sm " id="salesManagersTable">
                <thead class="fw-medium">
                    <tr class="fs-6">
                        <th style="width: 25%;">Name</th>
                        <th style="width: 25%;">Team</th>
                        <th style="width: 25%;">Status</th>
                        <th style="width: 25%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($salesManagers as $salesManager)
                        <tr class="fs-6 shadow-sm">
                            <td class="text-secondary fw-medium">{{ $salesManager->name }}</td>
                            <td class="text-secondary fw-medium">{{ $salesManager->team->name ?? 'N/A' }}</td>
                            <td>
                                <span class="badge {{ $salesManager->status === 'active' ? 'bg-active' : 'bg-inactive' }}">
                                    {{ ucfirst($salesManager->status) }}
                                </span>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('salesManagers.changeStatus', $salesManager->id) }}" class="d-inline" >
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-change-status btn-sm">Change Status</button>
                                </form>

                                <button
                                class="btn btn-edit btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#editSalesManagerModal"
                                data-id="{{ $salesManager->id }}"
                                data-name="{{ $salesManager->name }}"
                                data-username="{{ $salesManager->user->username }}"
                                data-email="{{ $salesManager->user->email }}"
                                data-viber-number="{{ $salesManager->user->viber_number }}"
                                data-team-id="{{ $salesManager->team_id }}"
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

<!-- Add Sales Manager Modal -->
<div class="modal fade" id="addSalesManagerModal" tabindex="-1" aria-labelledby="addSalesManagerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('salesManagers.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSalesManagerModalLabel">Add Sales Manager</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Username -->
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <!-- Password Confirmation -->
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>

                    <!-- Name -->
                    <div class="mb-3">
                        <label for="salesManagerName" class="form-label">Sales Manager Name</label>
                        <input type="text" class="form-control" id="salesManagerName" name="name" required>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <!-- Viber Number -->
                    <div class="mb-3">
                        <label for="viber_number" class="form-label">Viber Number</label>
                        <input type="text" class="form-control" id="viber_number" name="viber_number">
                    </div>

                    <!-- Team Selection Dropdown -->
                    <div class="mb-3">
                        <label for="teamSelect" class="form-label">Select Team</label>
                        <select class="form-select" id="teamSelect" name="team_id" required>
                            <option value="" disabled selected>Select a team</option>
                            @foreach($teams as $team)
                                <option value="{{ $team->id }}">{{ $team->name }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Sales Manager</button>
                </div>
            </div>
        </form>
    </div>
</div>



<!-- Edit Sales Manager Modal -->
<div class="modal fade" id="editSalesManagerModal" tabindex="-1" aria-labelledby="editSalesManagerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('salesManagers.update') }}">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSalesManagerModalLabel">Edit Sales Manager</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editSalesManagerId" name="id">

                    <!-- Username -->
                    <div class="mb-3">
                        <label for="editUsername" class="form-label">Username</label>
                        <input type="text" class="form-control" id="editUsername" name="username" required>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="editPassword" class="form-label">Password (Leave blank to keep current)</label>
                        <input type="password" class="form-control" id="editPassword" name="password">
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-3">
                        <label for="editPasswordConfirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="editPasswordConfirmation" name="password_confirmation">
                    </div>

                    <!-- Name -->
                    <div class="mb-3">
                        <label for="editSalesManagerName" class="form-label">Sales Manager Name</label>
                        <input type="text" class="form-control" id="editSalesManagerName" name="name" required>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="editEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editEmail" name="email" required>
                    </div>

                    <!-- Viber Number -->
                    <div class="mb-3">
                        <label for="editViberNumber" class="form-label">Viber Number</label>
                        <input type="text" class="form-control" id="editViberNumber" name="viber_number">
                    </div>

                    <!-- Team Selection Dropdown -->
                    <div class="mb-3">
                        <label for="editTeamSelect" class="form-label">Select Team</label>
                        <select class="form-select" id="editTeamSelect" name="team_id" required>
                            <option value="" disabled>Select a team</option>
                            @foreach($teams as $team)
                                <option value="{{ $team->id }}">{{ $team->name }}</option>
                            @endforeach
                        </select>
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
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Display success alert if present
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

        // Initialize DataTable for Sales Managers
        var table = $('#salesManagersTable').DataTable({
            paging: true,
            searching: true, // Enable search
            info: false, // Hide "Showing x of y" info
            order: [[1, 'asc']], // Default sorting: by Status
            pageLength: 10, // Default rows per page
            lengthChange: false, // Hide "Show entries" dropdown
            columnDefs: [
                { orderable: false, targets: [3] } // Disable sorting on Actions column
            ],
            language: {
                search: "" // Remove "Search:" label
            }
        });

        // Move search box to a custom container
        var searchBox = $('div.dataTables_filter');
        searchBox.appendTo('.SEARCHING').css({
            'float': 'right',
            'text-align': 'right'
        });
        searchBox.find('input').addClass('form-control').attr('placeholder', 'Search SM').css('width', '100%');

        // Handle Edit Button Click for Sales Manager
        $('#editSalesManagerModal').on('show.bs.modal', function(event) {
            var button = event.relatedTarget; // Button that triggered the modal
            var id = button.getAttribute('data-id');
            var name = button.getAttribute('data-name');
            var username = button.getAttribute('data-username');
            var email = button.getAttribute('data-email');
            var viber_number = button.getAttribute('data-viber-number');
            var teamId = button.getAttribute('data-team-id');

            // Fill hidden fields and input values
            document.getElementById('editSalesManagerId').value = id;
            document.getElementById('editSalesManagerName').value = name;
            document.getElementById('editUsername').value = username;
            document.getElementById('editEmail').value = email;
            document.getElementById('editViberNumber').value = viber_number;

            // Set the selected team in the dropdown
            var teamSelect = document.getElementById('editTeamSelect');
            Array.from(teamSelect.options).forEach(option => {
                option.selected = option.value == teamId;
            });
        });



    });
</script>

@endsection
