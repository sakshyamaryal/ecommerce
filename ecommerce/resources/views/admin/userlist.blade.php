@extends('layouts.admin.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <p class="text-white mt-5 mb-5">Welcome back, <b>{{ auth()->user()->name }}</b></p>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row tm-content-row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 tm-block-col">
                <div class="tm-bg-primary-dark tm-block tm-block-products">
                <h2 class="tm-block-title">User List</h2>

                    <div class="tm-product-table-container">
                        <!-- User Table -->
                        
                        <table class="table table-hover tm-table-small tm-product-table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr class="tm-product-row">
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span id="{{ $user->id }}-role-badge">
                                            @if($user->role_id == 1)
                                                <span class="badge badge-success">Admin</span>
                                            @else
                                                <span class="badge badge-danger">User</span>
                                            @endif
                                        </span>
                                    </td>

                                    <td>{{ $user->created_at }}</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="User Actions">
                                            <button type="button" class="btn btn-warning btn-sm" onclick="changeRole('{{ $user->id }}', '{{ $user->role_id }}')">
                                                Change Role
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- End User Table -->
                    </div>
                    <!-- <a href="{{ url('users/create') }}" class="btn btn-primary btn-block text-uppercase mb-3">Add new user</a> -->
                </div>
            </div>
        </div>
    </div>
</div>


<script>
function changeRole(userId, currentRole) {
    var newRole = currentRole == 1 ? 2 : 1;
    var url = "{{ route('users.changeRole') }}";
    var n = userId;
    Swal.fire({
        title: 'Are you sure?',
        text: "You are about to change the user's role.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, change it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    user_id: userId,
                    new_role: newRole
                },
                success: function(response) {
                    // Update the badge based on the new role
                    var badge = newRole == 2 ? '<span class="badge badge-danger">User</span>' : '<span class="badge badge-success">Admin</span>';
                    $(`#${n}-role-badge`).html(badge);
                    // Show success message
                    Swal.fire('Success!', 'User role changed successfully.', 'success');
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    // Show error message
                    Swal.fire('Error!', 'An error occurred while changing user role.', 'error');
                }
            });
        }
    });
}



</script>


@endsection
