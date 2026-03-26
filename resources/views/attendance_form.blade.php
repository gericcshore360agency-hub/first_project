<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('my_resources/logo.png') }}">
    <title>Log Attendance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center justify-content-center" style="min-height:100vh; background:#f8f9fa;">

<div class="card p-4 shadow-sm" style="width: 100%; max-width: 420px;">

    <h5 class="mb-1">ATTENDANCE LOG</h5>

    <p class="text-muted small mb-4">{{ \Carbon\Carbon::parse($date)->format('F d, Y') }}</p>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('attendance.store') }}">
        
        @csrf
        
        <input type="hidden" name="date" value="{{ $date }}">

        <div class="mb-3">
            <label class="form-label">First name</label>
            <input type="text" name="first_name"
                   class="form-control @error('first_name') is-invalid @enderror"
                   value="{{ old('first_name') }}" placeholder="First name">
            @error('first_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Last name</label>
            <input type="text" name="last_name"
                   class="form-control @error('last_name') is-invalid @enderror"
                   value="{{ old('last_name') }}" placeholder="Last name">
            @error('last_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary w-100">Submit attendance</button>
    </form>
</div>

</body>
</html>