<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('my_resources/logo.png') }}">
    <title>Parent Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/styles/dashboard.css') }}">
</head>
<body>

<div class="container-fluid px-4 py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Student Data Report</h2>
            <p class="text-muted mb-0">Teacher: <strong>{{ $selectedTeacher->name }}</strong></p>
        </div>
        <div class="d-flex gap-2">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm">EXIT</button>
            </form>
        </div>
    </div>

    <hr class="mb-4">

    <!-- Student Stats Row -->
    <div class="row g-3 mb-4">

        <!-- Name Card -->
        <div class="col-12 col-md-3">
            <div class="card shadow-sm border-0 p-4 h-100 text-center">
                <div class="mx-auto mb-3 rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center"
                     style="width:64px; height:64px;">
                    <span class="fw-700 text-primary fs-4">
                        {{ strtoupper(substr($selectedStudent->first_name, 0, 1)) }}
                    </span>
                </div>
                <h5 class="mb-1">{{ $selectedStudent->first_name }} {{ $selectedStudent->last_name }}</h5>
                <p class="text-muted mb-0" style="font-size:0.85rem;">{{ $selectedStudent->student_number }}</p>
            </div>
        </div>

        <!-- Present -->
        <div class="col-6 col-md-2">
            <div class="card shadow-sm border-0 p-4 h-100 text-center">
                <p class="text-muted mb-1" style="font-size:0.8rem;">Present</p>
                <h2 class="fw-700 text-success mb-0">{{ $selectedStudent->attendances_count }}</h2>
                <p class="text-muted mt-1 mb-0" style="font-size:0.75rem;">days</p>
            </div>
        </div>

        <!-- Absent -->
        <div class="col-6 col-md-2">
            <div class="card shadow-sm border-0 p-4 h-100 text-center">
                <p class="text-muted mb-1" style="font-size:0.8rem;">Absent</p>
                <h2 class="fw-700 text-danger mb-0">{{ $totalDays - $selectedStudent->attendances_count }}</h2>
                <p class="text-muted mt-1 mb-0" style="font-size:0.75rem;">days</p>
            </div>
        </div>

        <!-- Total Days -->
        <div class="col-6 col-md-2">
            <div class="card shadow-sm border-0 p-4 h-100 text-center">
                <p class="text-muted mb-1" style="font-size:0.8rem;">Total Days</p>
                <h2 class="fw-700 mb-0">{{ $totalDays }}</h2>
                <p class="text-muted mt-1 mb-0" style="font-size:0.75rem;">days</p>
            </div>
        </div>

        <!-- Attendance Rate -->
        <div class="col-6 col-md-3">
            <div class="card shadow-sm border-0 p-4 h-100 text-center">
                <p class="text-muted mb-1" style="font-size:0.8rem;">Attendance Rate</p>
                <h2 class="fw-700 mb-2 {{ $attendanceRate >= 80 ? 'text-success' : 'text-warning' }}">
                    {{ $attendanceRate }}%
                </h2>
                <span class="badge {{ $attendanceRate >= 80 ? 'bg-success' : 'bg-warning' }} px-3 py-2">
                    {{ $attendanceRate >= 80 ? 'Good' : 'At Risk' }}
                </span>
            </div>
        </div>

    </div>

    <!-- Attendance Records Table -->
    <h6 class="mb-3">Attendance Records</h6>
    <div class="card shadow-sm border-0 p-3">
        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Day</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($studentAttendance as $record)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($record->date)->format('M d, Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($record->date)->format('l') }}</td>
                            <td><span class="badge bg-success">Present</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-muted py-4">No attendance records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>