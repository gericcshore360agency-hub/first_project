<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="icon" type="image/png" href="{{ asset('my_resources/logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('styles/dashboard.css') }}">

</head>
<body>

<div class="container-fluid">
    <div class="row">

         <!--My Sidebar is in here MULALA-->
        @include('profile.sidebar')

        <!--My Main Content is in here MULALA-->
<div class="col-md-10 main-content d-flex align-items-center" style="min-height: 100vh;">
    <div class="card shadow-lg card-custom p-4 w-100 flex-grow-1 d-flex flex-column justify-content-start" style="min-height: auto;">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h2 class="mb-1">Users</h2>
                <p class="text-muted mb-0">Manage your system users</p>
            </div>

            <!-- Add Button -->
            <a href="{{ route('add_user') }}" class="btn btn-primary">Add User</a>
        </div>

        <!-- Users Table -->
        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th class="d-none d-md-table-cell">Number</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th class="d-none d-md-table-cell">Roles</th>
                        <th class="d-none d-md-table-cell">Permissions</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse($users as $index => $user)
                        <tr>
                            <td class="d-none d-md-table-cell">{{ $index + 1 }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td class="d-none d-md-table-cell">{{ $user->getRoleNames()->join(', ') }}</td>
                            <td class="d-none d-md-table-cell">{{ $user->getAllPermissions()->pluck('name')->join(', ') }}</td>
                                <td>
                                    <div class="d-flex flex-column flex-sm-row gap-1 justify-content-center">
                                        <a href="{{ route('edit_user', $user->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        
                                        <form action="{{ route('delete_user', $user->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this user?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger w-100">Delete</button>
                                        </form>
                                    </div>
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