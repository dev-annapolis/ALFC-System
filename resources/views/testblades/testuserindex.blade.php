@extends('layouts.app')

@section('content')
<style>
    /* Set the width of the offcanvas to 70% */
    
    @media (min-width: 992px) { /* For large screens */
        .custom-offcanvas {
            width: 35% !important; /* Make it 70% width on large screens */
        }
    }

    @media (max-width: 991px) { /* For smaller screens */
        .custom-offcanvas {
            width: 100% !important; /* Full width on smaller screens */
        }
    }
</style>
<div class="container">
    <h1 class="my-4">User List</h1>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <!-- Button to open the offcanvas sidebar -->
                        <button 
                            class="btn btn-primary btn-sm view-user-btn" 
                            data-bs-toggle="offcanvas" 
                            data-bs-target="#userDetailSidebar" 
                            data-id="{{ $user->id }}"
                        >
                            View
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="offcanvas offcanvas-end custom-offcanvas" tabindex="-1" id="userDetailSidebar" aria-labelledby="userDetailSidebarLabel" data-bs-backdrop="false">
        <div class="offcanvas-header">
            <h5 id="userDetailSidebarLabel">User Details</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <!-- Placeholder for user details -->
            <p id="userDetailsContent">Select a user to view details.</p>
        </div>
    </div>
</div>

<!-- Offcanvas sidebar for user details -->

@endsection


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Make sure jQuery is included -->

<script>
    $(document).ready(function () {
        // Event listener for the "View" button
        $('.view-user-btn').click(function () {
            var userId = $(this).data('id');  // Get the user ID from the button data attribute

            // Use jQuery AJAX to fetch the user details
            $.ajax({
                url: "{{ url('users') }}/" + userId,  // Use Laravel's URL helper to generate the URL
                method: 'GET',
                dataType: 'json',
                success: function (user) {
                    console.log(user);
                    // Update the sidebar content with user details
                    $('#userDetailsContent').html(`
                        <p><strong>ID:</strong> ${user.id}</p>
                        <p><strong>Username:</strong> ${user.username}</p>
                        <p><strong>Name:</strong> ${user.name}</p>
                        <p><strong>Email:</strong> ${user.email}</p>
                    `);
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching user data:', error);
                    $('#userDetailsContent').html('Failed to load user details.');
                }
            });
        });
    });
</script>

