<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('my_resources/logo.png') }}">
    <title>Edit User</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/styles/dashboard.css') }}">
</head>
<body>

<div class="container-fluid">
    <div class="row">

        <!-- Sidebar -->
        @include('profile.sidebar')

        <!-- Main Content -->
        <div class="col-md-10 main-content d-flex align-items-center justify-content-center" style="min-height: 100vh;">
            <div class="card shadow-lg card-custom p-4 w-100 flex-grow-1 d-flex flex-column justify-content-start" style="min-height: auto;">

                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h2 class="mb-1">Edit User</h2>
                        <p class="text-muted mb-0">Update user information</p>
                    </div>
                    <a href="{{ route('show_users') }}" class="btn btn-secondary">← Back</a>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('update_user', $user->id) }}">

                    @csrf
                    
                    @method('PUT')

                    <div class="row">

                        <!-- Name -->
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" 
                                value="{{ old('name', $user->name) }}" 
                                class="form-control">
                            @error('name')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" 
                                value="{{ old('email', $user->email) }}" 
                                class="form-control">
                            @error('email')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password (optional) -->
                        <div class="col-md-12 mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" name="password" class="form-control">
                            <small class="text-muted">Leave blank if unchanged</small>
                            @error('password')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>

                        <!-- Roles -->
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Roles</label>
                            <select name="roles[]" class="form-select" multiple>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}"
                                        {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <!-- Submit -->
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Update User</button>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>