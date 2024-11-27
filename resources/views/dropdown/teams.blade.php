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
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">


<div class="container-fluid p-5">
    @if (session('success'))
        <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row TOP-ROW mb-3">
        <div class="col-md-6 TEAMS-MASTERLIST">
            <h1 class="fs-2 fw-medium">Master List of <strong>Teams</strong></h1>
        </div>
        <div class="col-md-6 SEARCHING d-flex align-items-center justify-content-end">
            <!-- Add Team Button -->
            <button class="btn btn-sm btn-primary fs-6 pe-3 me-3" data-bs-toggle="modal" data-bs-target="#addTeamModal">
                <i class="me-2 ms-2 fa-solid fa-plus"></i>
                Add Team
            </button>
            <!-- Search box will be initialized by DataTables -->
        </div>
    </div>

    <div class="table-container">

        <div class="table-responsive">
            <table class="table dt-responsive shadow-sm " id="teamsTable">
                <thead class="fw-medium">
                    <tr class="fs-6">
                        <th style="width: 33%;">Name</th>
                        <th style="width: 33%;">Status</th>
                        <th style="width: 33%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($teams as $team)
                        <tr class="fs-6 shadow-sm">
                            <td class="text-secondary fw-medium">{{ $team->name }}</td>
                            <td>
                                <span class="badge {{ $team->status === 'active' ? 'bg-active' : 'bg-inactive' }}">
                                    {{ ucfirst($team->status) }}
                                </span>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('teams.changeStatus', $team->id) }}" class="d-inline" >
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-change-status btn-sm">Change Status</button>
                                </form>

                                <button class="btn btn-edit btn-sm" data-bs-toggle="modal" data-bs-target="#editTeamModal" data-id="{{ $team->id }}" data-name="{{ $team->name }}" style="margin-left: 0.5rem;">
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

<!-- Add Team Modal -->
<div class="modal fade" id="addTeamModal" tabindex="-1" aria-labelledby="addTeamModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('teams.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTeamModalLabel">Add Team</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="teamName" class="form-label">Team Name</label>
                        <input type="text" class="form-control" id="teamName" name="name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Team</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Edit Team Modal -->
<div class="modal fade" id="editTeamModal" tabindex="-1" aria-labelledby="editTeamModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('teams.update') }}">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTeamModalLabel">Edit Team</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editTeamId" name="id">
                    <div class="mb-3">
                        <label for="editTeamName" class="form-label">Team Name</label>
                        <input type="text" class="form-control" id="editTeamName" name="name" required>
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


<!-- JavaScript to fade out the alert after 1 second -->
<script>
    // Show the success alert if it's present
    var successAlert = document.getElementById('success-alert');
    if (successAlert) {
        successAlert.style.display = 'block';  // Make alert visible
        setTimeout(function() {
            successAlert.classList.remove('show');
            successAlert.classList.add('fade');
        }, 1200);  // 1 second delay before fading out
    }
</script>

<script>
    // Handle Edit Button Click
    document.getElementById('editTeamModal').addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');
        var name = button.getAttribute('data-name');
        document.getElementById('editTeamId').value = id;
        document.getElementById('editTeamName').value = name;
    });
</script>



<script>
    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#teamsTable').DataTable({
            paging: true,
            searching: true, // Ensure search is enabled
            info: false,
            order: [[0, 'asc']],
            pageLength: 10,
            lengthChange: false, // Hide the "Show entries" dropdown

            columnDefs: [
                { orderable: false, targets: [2] } // Disable sorting on Actions column
            ],
            language: {
                search: "" // Remove "Search:" label by setting it to an empty string
            }
        });

        // Move the search box to .SEARCHING
        var searchBox = $('div.dataTables_filter');
        if (searchBox.length > 0) {
            searchBox.appendTo('.SEARCHING').css({
                'float': 'right',
                'text-align': 'right'
            });

            searchBox.find('input').addClass('form-control').attr('placeholder', 'Search Teams').css('width', '100%');
            console.log("Search box moved successfully!");
        } else {
            console.error("Search box (dataTables_filter) not found!");
        }
    });
</script>


@endsection
