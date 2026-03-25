<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Teacher</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Poppins Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('/styles/base.css') }}">
</head>
<body class="d-flex align-items-center min-vh-100">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 d-flex align-items-center justify-content-center">

                <div class="card shadow-lg card-custom p-5 text-center w-100">

                    <h2 class="mb-3">Find Your Teacher</h2>

                    <p class="text-muted mb-4">
                        Enter your teacher's name to continue
                    </p>

                    <form method="POST" action="{{ route('load_teacher') }}">

                        @csrf

                        <div class="mb-3 text-start">
                            <label for="teacher_name" class="form-label">Teacher Name</label>
                            <input
                                id="teacher_name"
                                type="text"
                                class="form-control @error('teacher_name') is-invalid @enderror"
                                name="teacher_name"
                                value="{{ old('teacher_name') }}"
                                required
                                autofocus
                            >
                            @error('teacher_name')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 text-start">
                            <label for="student_name" class="form-label">Student Name</label>
                            <input
                                id="student_name"
                                type="text"
                                class="form-control @error('student_name') is-invalid @enderror"
                                name="student_name"
                                value="{{ old('student_name') }}"
                                required
                                autofocus
                            >
                            @error('student_name')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary">Continue</button>
                        </div>

                    </form>

                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>