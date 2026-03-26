<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('my_resources/logo.png') }}">
    <title>Roles</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/styles/dashboard.css') }}">
</head>
<body>

<div class="container-fluid">
    <div class="row">

        @include('profile.sidebar')

        <div class="col-md-10 main-content d-flex align-items-center justify-content-center" style="min-height: 100vh;">
            <div class="card shadow-lg card-custom p-4 w-100 flex-grow-1 d-flex flex-column justify-content-start" style="min-height: auto;">

                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h2 class="mb-1">Roles</h2>
                        <p class="text-muted mb-0">Manage roles and their permissions</p>
                    </div>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createRoleModal">
                        Add Role
                    </button>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <!-- Roles Table -->
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Role</th>
                                <th>Permissions</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($roles as $index => $role)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        @forelse($role->permissions as $permission)
                                            <span class="badge bg-secondary">{{ $permission->name }}</span>
                                        @empty
                                            <span class="text-muted small">No permissions</span>
                                        @endforelse
                                    </td>
                                    <td>
                                        @if($role->name !== 'admin')
                                            <button class="btn btn-sm btn-warning"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editRoleModal{{ $role->id }}">
                                                Edit
                                            </button>

                                            {{-- Button triggers the hidden form outside the table --}}
                                            <button class="btn btn-sm btn-danger"
                                                onclick="if(confirm('Are you sure you want to delete this role?')) document.getElementById('deleteRoleForm{{ $role->id }}').submit()">
                                                Delete
                                            </button>
                                        @else
                                            <span class="text-muted small">Protected</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-muted">No roles found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
</div>

{{-- Delete forms — outside the table --}}
@foreach($roles as $role)
    @if($role->name !== 'admin')
        <form id="deleteRoleForm{{ $role->id }}"
              action="{{ route('delete_role', $role->id) }}"
              method="POST"
              class="d-none">
            @csrf
            @method('DELETE')
        </form>
    @endif
@endforeach

{{-- Edit Role Modals --}}
@foreach($roles as $role)
<div class="modal fade" id="editRoleModal{{ $role->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('edit_role', $role->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Role — {{ $role->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Role name</label>
                        <input type="text" name="name" class="form-control" value="{{ $role->name }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Permissions</label>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($permissions as $permission)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                        name="permissions[]"
                                        value="{{ $permission->name }}"
                                        id="perm-{{ $role->id }}-{{ $permission->id }}"
                                        {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perm-{{ $role->id }}-{{ $permission->id }}">
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

{{-- Create Role Modal --}}
<div class="modal fade" id="createRoleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('create_role') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Role name</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. substitute_teacher">
                        @error('name')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Permissions</label>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($permissions as $permission)
                                <div class="form-check">
                                    <input class="form-check-input"
                                        type="checkbox"
                                        name="permissions[]"
                                        value="{{ $permission->name }}"
                                        id="new-perm-{{ $permission->id }}">
                                    <label class="form-check-label" for="new-perm-{{ $permission->id }}">
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Role</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>