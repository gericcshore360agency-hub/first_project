<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('/styles/dashboard.css') }}">

</head>
<body>

<div class="container-fluid">
    <div class="row">

         <!--My Sidebar is in here MULALA-->
        @include('profile.sidebar')

        <!--My Main Content is in here MULALA-->
<div class="col-md-10 main-content">
    <div class="card shadow-lg card-custom p-4">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h2 class="mb-1">Users</h2>
                <p class="text-muted mb-0">Manage your system users</p>
            </div>

            <!-- Optional Add Button -->
            <a href="{{ route('add_user') }}" class="btn btn-primary">Add User</a>
        </div>

        <!-- Search (optional but nice) -->
        <div class="mb-3">
            <input type="text" class="form-control" placeholder="Search users...">
        </div>

        <!-- Users Table -->
        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Roles</th>
                        <th>Permissions</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse($users as $index => $user)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->getRoleNames()->join(', ') }}</td>
                            <td>{{ $user->getAllPermissions()->pluck('name')->join(', ') }}</td>
                            <td>
                                <a href="{{ route('edit_user', $user->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="#" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-muted">
                                No users found.
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        <!-- Optional Pagination -->
        <div class="mt-3">
            {{ $users->links() }}
        </div>

    </div>
</div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>