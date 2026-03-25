<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/styles/dashboard.css') }}">
</head>
<body>

<div class="container">
    <div class="row">

        <!-- Main Content -->
        <div class="col-12 main-content" style="margin-left: 0;">
            <div class="card shadow-lg card-custom p-4">

                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="mb-1">Parent Dashboard</h2>
                        <p class="text-muted mb-0">Viewing records for <strong>{{ $selectedTeacher->name }}</strong></p>
                    </div>
                    <div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-danger">Logout</button>
                        </form>
                    </div>
                </div>

                <hr class="mb-4">

                <!-- Student List -->
                <div>
                    <h5 class="mb-4 text-center">STUDENT</h5>
                    <div class="row justify-content-center">
                        @forelse($students as $student)
                            <div class="col-lg-6 col-md-6 mb-5">
                                <div class="card h-100 shadow-sm border-0">
                                    <div class="card-body text-center p-4">
                                        <h5 class="card-title mb-3">{{ $student['name'] }}</h5>
                                        <p class="card-text mb-2"><strong>Student Number:</strong> {{ $student['student_number'] }}</p>
                                        <div class="row">
                                            <div class="col-6">
                                                <p class="card-text mb-2"><strong>Present Days:</strong><br>{{ $student['present'] }}</p>
                                            </div>
                                            <div class="col-6">
                                                <p class="card-text mb-2"><strong>Absent Days:</strong><br>{{ $student['absences'] }}</p>
                                            </div>
                                        </div>
                                        <p class="card-text mb-2"><strong>Total Days:</strong> {{ $student['total_days'] }}</p>
                                        <p class="card-text mb-2"><strong>Attendance Rate:</strong> {{ $student['attendance_rate'] }}%</p>
                                        <p class="card-text">
                                            <span class="badge {{ $student['status'] === 'Good' ? 'bg-success' : 'bg-warning' }} fs-6 px-3 py-2">
                                                {{ $student['status'] }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center">
                                <p class="text-muted">No student data available yet.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>