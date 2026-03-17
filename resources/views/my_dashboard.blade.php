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
                <h2 class="mb-3">Welcome, {{ Auth::user()->name }}</h2>
                <p class="text-muted mb-4">Here is your dashboard overview:</p>

                <div class="row">
                    <div class="col-md-4">
                        <div class="card p-3 mb-3">
                            <h5>Email</h5>
                            <p>{{ Auth::user()->email }}</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card p-3 mb-3">
                            <h5>Roles</h5>
                            <p>{{ Auth::user()->getRoleNames()->join(', ') }}</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card p-3 mb-3">
                            <h5>Permissions</h5>
                            <p>{{ Auth::user()->getAllPermissions()->pluck('name')->join(', ') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Additional dashboard content -->
                <div class="mt-4">
                    <h5>Quick Actions</h5>
                    <a href="#" class="btn btn-primary me-2">New Post</a>
                    <a href="#" class="btn btn-secondary">Manage Users</a>
                </div>

            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>