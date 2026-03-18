<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance</title>

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
        <div class="col-md-10 main-content py-4">
            <div class="container">

                <!-- Profile Information -->
                <div class="card shadow-lg card-custom p-4 mb-4">
                    <h2 class="mb-3">Profile Information</h2>
                    <p class="text-muted mb-4">
                        Update your account's profile information and email address.
                    </p>

                    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                        @csrf
                    </form>

                    <form method="post" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" required autofocus>
                            <x-input-error class="mt-1 text-danger" :messages="$errors->get('name')" />
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                            <x-input-error class="mt-1 text-danger" :messages="$errors->get('email')" />

                            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                <p class="text-muted mt-2">
                                    Your email address is unverified. 
                                    <button form="send-verification" class="btn btn-link p-0">Click here to re-send the verification email.</button>
                                </p>

                                @if (session('status') === 'verification-link-sent')
                                    <p class="text-success mt-2">A new verification link has been sent to your email address.</p>
                                @endif
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary">Save</button>

                        @if (session('status') === 'profile-updated')
                            <span class="text-success ms-2" id="profile-saved-msg">Saved.</span>
                        @endif
                    </form>
                </div>

                <!-- Update Password -->
                <div class="card shadow-lg card-custom p-4 mb-4">
                    <h2 class="mb-3">Update Password</h2>
                    <p class="text-muted mb-4">
                        Ensure your account is using a long, random password to stay secure.
                    </p>

                    <form method="post" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input id="current_password" name="current_password" type="password" class="form-control">
                            @error('current_password')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input id="password" name="password" type="password" class="form-control">
                            @error('password')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" class="form-control">
                            @error('password_confirmation')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Save</button>

                        @if (session('status') === 'password-updated')
                            <span class="text-success ms-2" id="password-saved-msg">Saved.</span>
                        @endif
                    </form>
                </div>

                <!-- Delete Account -->
                <div class="card shadow-lg card-custom p-4 mb-4">
                    <h2 class="mb-3 text-danger">Delete Account</h2>
                    <p class="text-muted mb-4">
                        Once your account is deleted, all resources and data will be permanently deleted. 
                        Please enter your password to confirm.
                    </p>

                    <!-- Trigger Delete Modal -->
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                        Delete Account
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <form method="post" action="{{ route('profile.destroy') }}">
                                @csrf
                                @method('delete')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-danger">Confirm Deletion</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="text-muted">
                                            Enter your password to confirm account deletion.
                                        </p>
                                        <input type="password" name="password" class="form-control" placeholder="Password">
                                        @error('password')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-danger">Delete Account</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Auto-hide success messages
    ['profile-saved-msg', 'password-saved-msg'].forEach(id => {
        const el = document.getElementById(id);
        if (el) setTimeout(() => el.style.display = 'none', 2000);
    });
</script>