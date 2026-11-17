<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') — Peminjaman Sarpras</title>
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/overlayscrollbars/overlayscrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    @stack('styles')
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        <!-- Navbar -->
        <nav class="app-header navbar navbar-expand bg-body">
            <div class="container-fluid">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button" aria-label="Buka atau tutup menu navigasi"><i class="bi bi-list fs-4" aria-hidden="true"></i></a>
                    </li>
                    <li class="nav-item d-none d-md-block">
                        <span class="nav-link fw-semibold">Pencatatan Peminjaman Sarana dan Prasarana SMK Bakti Nusantara 666</span>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown user-menu">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <span class="d-none d-md-inline">{{ Auth::user()->nama_petugas }}</span>
                            <span class="badge bg-secondary ms-1 text-uppercase">{{ Auth::user()->level->nama_level ?? '' }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow">
                            <li class="user-footer p-2 text-center">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm w-100" aria-label="Keluar"><i class="bi bi-box-arrow-right me-1" aria-hidden="true"></i> Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- Sidebar -->
        <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
            <div class="sidebar-brand">
                <a href="{{ route('dashboard') }}" class="brand-link text-decoration-none" aria-label="Peminjaman Sarpras">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" width="24" height="24" class="me-2" style="object-fit: contain;">
                    <span class="brand-text fw-bold">Peminjaman Sarpras</span>
                </a>
            </div>
            <div class="sidebar-wrapper">
                <nav class="mt-2">
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-speedometer2" aria-hidden="true"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        @if(Auth::user()->isAdmin())
                            <li class="nav-header">DATA INDUK (ADMIN)</li>
                            <li class="nav-item">
                                <a href="{{ route('petugas.index') }}" class="nav-link {{ request()->routeIs('petugas.*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-people" aria-hidden="true"></i>
                                    <p>Petugas</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('kategori.index') }}" class="nav-link {{ request()->routeIs('kategori.*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-tags" aria-hidden="true"></i>
                                    <p>Kategori</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('ruang.index') }}" class="nav-link {{ request()->routeIs('ruang.*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-door-open" aria-hidden="true"></i>
                                    <p>Ruang</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('inventaris.index') }}" class="nav-link {{ request()->routeIs('inventaris.*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-box-seam" aria-hidden="true"></i>
                                    <p>Inventaris</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('peminjam.index') }}" class="nav-link {{ request()->routeIs('peminjam.*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-person-badge" aria-hidden="true"></i>
                                    <p>Peminjam</p>
                                </a>
                            </li>
                        @endif

                        @if(Auth::user()->isOperator())
                            <li class="nav-header">TRANSAKSI & DATA</li>
                            <li class="nav-item">
                                <a href="{{ route('peminjam.index') }}" class="nav-link {{ request()->routeIs('peminjam.*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-person-badge" aria-hidden="true"></i>
                                    <p>Peminjam</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('peminjaman.create') }}" class="nav-link {{ request()->routeIs('peminjaman.*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-plus-square" aria-hidden="true"></i>
                                    <p>Peminjaman Baru</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('pengembalian.index') }}" class="nav-link {{ request()->routeIs('pengembalian.*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-arrow-return-left" aria-hidden="true"></i>
                                    <p>Pengembalian</p>
                                </a>
                            </li>
                        @endif

                    <li class="nav-header">LAPORAN</li>
                        <li class="nav-item">
                            <a href="{{ route('riwayat.index') }}" class="nav-link {{ request()->routeIs('riwayat.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-file-earmark-text" aria-hidden="true"></i>
                                <p>Riwayat & Export</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        <!-- Main Content -->
        <main class="app-main">
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">@yield('header', 'Dashboard')</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="app-content">
                <div class="container-fluid">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @yield('content')
                </div>
            </div>
        </main>
        <footer class="app-footer text-end px-4 py-2 small text-muted">
            Made with <3 by uzi &bull; Using Laravel 13 x AdminLTE 4 (Edisi malas ngoding)
        </footer>
    </div>
    <script src="{{ asset('vendor/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/adminlte.min.js') }}"></script>
    <script src="{{ asset('vendor/overlayscrollbars/overlayscrollbars.browser.es6.min.js') }}"></script>
    @stack('scripts')
</body>
</html>
