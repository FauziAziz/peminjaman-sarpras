<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login — Peminjaman Sarpras</title>
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/adminlte.min.css') }}">
</head>
<body class="login-page bg-body-secondary d-flex flex-column justify-content-center align-items-center vh-100">
    <div class="login-box w-100" style="max-width: 400px;">
        <div class="card card-outline card-primary shadow-sm">
            <div class="card-header text-center">
                <a href="/" class="link-dark text-decoration-none fs-4 fw-bold">
                    <i class="bi bi-box-seam text-primary me-2"></i>Peminjaman<strong>Sarpras</strong>
                </a>
            </div>
            <div class="card-body login-card-body rounded-bottom">
                @yield('content')
            </div>
        </div>
    </div>
    <script src="{{ asset('vendor/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/adminlte.min.js') }}"></script>
</body>
</html>
