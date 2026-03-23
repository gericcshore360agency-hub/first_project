<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Add User</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Poppins Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('/styles/dashboard.css') }}">
</head>
<body>

<div class="container-fluid">
    <div class="row">

        <!-- Sidebar -->
        @include('profile.sidebar')

        <!-- Main Content -->
        <div class="col-lg-10 col-md-9 col-12 main-content" style="height: 100vh;">

            <div class="d-flex justify-content-center align-items-center h-100">

                <div class="card shadow-lg card-custom p-4 w-100" style="max-width: 700px;">

                    <!-- Header -->
                    <h2 class="mb-3 text-center">Add User</h2>

                    <p class="text-muted mb-4 text-center">Create a new user account</p>


                    <!-- Form -->
                    <form method="POST" action="{{ route('create_users') }}">

                        @csrf
                        
                        <div class="row">

                            <!-- Name -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                                @error('name')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control">
                                @error('email')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control">
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
                            <div class="col-12 mb-3">
                                <label class="form-label">Assign Roles</label>
                                <div class="d-flex flex-wrap gap-3">
                                    @foreach($roles as $role)
                                        <div class="form-check">
                                            <input 
                                                class="form-check-input"
                                                type="checkbox"
                                                name="roles[]"
                                                value="{{ $role->name }}"
                                                id="role-{{ $role->id }}"
                                            >
                                            <label class="form-check-label" for="role-{{ $role->id }}">
                                                {{ $role->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2 mt-3 justify-content-center">
                            <button type="submit" class="btn btn-primary">Create User</button>
                            <a href="{{ route('show_users') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>