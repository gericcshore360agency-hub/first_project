<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="icon" type="image/png" href="{{ asset('my_resources/logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/styles/dashboard.css') }}">
</head>
<body>

<div class="container-fluid">
    <div class="row">

        @include('profile.sidebar')

        <div class="col-md-10 main-content d-flex align-items-center justify-content-center" style="min-height: 100vh;">
            <div class="card shadow-lg card-custom p-4 w-100 flex-grow-1 d-flex flex-column justify-content-start" style="min-height: 600px;">

                <!-- Welcome Header -->
                <div class="mb-4">
                    <h2 class="mb-1">Welcome, {{ Auth::user()->name }}</h2>
                    <p class="text-muted mb-0">Here is your dashboard overview</p>
                </div>

                <!-- User Info Cards -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card p-3 h-100">
                            <p class="text-muted small mb-1">Email</p>
                            <p class="mb-0 fw-500">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card p-3 h-100">
                            <p class="text-muted small mb-1">Roles</p>
                            <p class="mb-0">{{ Auth::user()->getRoleNames()->join(', ') }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card p-3 h-100">
                            <p class="text-muted small mb-1">Permissions</p>
                            <p class="mb-0">{{ Auth::user()->getAllPermissions()->pluck('name')->join(', ') }}</p>
                        </div>
                    </div>
                </div>

                <hr class="mb-4">

                <!-- Past 7 Days Attendance -->
                <div class="mb-4">
                    <h5 class="mb-3">Recent Attendance</h5>
                    <div class="row">
                        @foreach($recentDays as $day)
                            <div class="col-md-4">
                                <div class="card p-3 mb-3 text-center">
                                    <p class="text-muted small mb-1">{{ $day['day_name'] }}</p>
                                    <p class="fw-500 mb-2">{{ $day['formatted_date'] }}</p>
                                    <h3 class="mb-0">
                                        <span class="badge bg-primary fs-5">{{ $day['count'] }}</span>
                                    </h3>
                                    <p class="text-muted small mt-1 mb-0">students present</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <hr class="mb-4">

                <!-- Student Status -->
                <div>
                    <h5 class="mb-3">Student Status</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>Student</th>
                                    <th>Student Number</th>
                                    <th>Present</th>
                                    <th>Total Days</th>
                                    <th>Attendance Rate</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students as $student)
                                    <tr>
                                        <td>{{ $student['name'] }}</td>
                                        <td>{{ $student['student_number'] }}</td>
                                        <td>{{ $student['present'] }}</td>
                                        <td>{{ $student['total_days'] }}</td>
                                        <td>{{ $student['attendance_rate'] }}%</td>
                                        <td>
                                            <span class="badge {{ $student['status'] === 'Good' ? 'bg-success' : 'bg-warning' }}">
                                                {{ $student['status'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-muted">
                                            No student data available yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>