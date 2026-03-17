<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>First Project</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('/styles/welcome.css') }}">

</head>
<body class="d-flex align-items-center min-vh-100">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 offset-md-6 d-flex align-items-center justify-content-center">

                <div class="card shadow-lg card-custom p-5 text-center w-100">
                    <h2 class="mb-3">Welcome</h2>
                    <p class="text-muted mb-4">
                        Please login or register to continue
                    </p>

                    <div class="d-grid gap-2">
                        <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-outline-secondary">Register</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>