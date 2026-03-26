<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance</title>
<link rel="icon" type="image/png" href="{{ asset('my_resources/logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/styles/dashboard.css') }}">
</head>
<body>

<div class="container-fluid">
    <div class="row">

        @include('profile.sidebar')

        <div class="col-md-10 main-content d-flex align-items-center" style="min-height: 100vh;">
            <div class="card shadow-lg card-custom p-4 w-100 flex-grow-1 d-flex flex-column justify-content-start" style="min-height: 600px;">
                
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h2 class="mb-0">Attendance</h2>

                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#qrModal">
                        Generate QR code
                    </button>
                </div>

                <p class="text-muted mb-4">
                    Records for: <strong>{{ $date }}</strong>
                </p>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($records as $index => $record)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $record->first_name }}</td>
                                    <td>{{ $record->last_name }}</td>
                                    <td>{{ $record->date }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-muted">
                                        No attendance records found for this date.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Back to Calendar</a>
                </div>

            </div>
        </div>

    </div>
</div>

<!-- QR Modal -->
<div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="qrModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="qrModalLabel">Today's Attendance QR</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body text-center">
                <p class="text-muted small mb-3">
                    Students scan this to log their attendance for <strong>{{ $date }}</strong>
                </p>

                <div class="d-flex justify-content-center mb-3">
                    {!! $qrCode !!}
                </div>

                <div class="mt-2 mb-2">
                    <a href="{{ $scanUrl }}" target="_blank" class="text-break small">
                        {{ $scanUrl }}
                    </a>
                </div>

                <small class="text-muted">QR is tied to this date only</small>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>