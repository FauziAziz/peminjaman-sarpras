@extends('layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
<div class="row">
    @if($user->isAdmin())
        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-primary shadow-sm">
                <div class="inner">
                    <h3>{{ $stats['total_petugas'] }}</h3>
                    <p>Total Petugas</p>
                </div>
                <div class="small-box-icon"><i class="bi bi-people"></i></div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-success shadow-sm">
                <div class="inner">
                    <h3>{{ $stats['total_kategori'] }}</h3>
                    <p>Kategori Barang</p>
                </div>
                <div class="small-box-icon"><i class="bi bi-tags"></i></div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-warning shadow-sm">
                <div class="inner">
                    <h3>{{ $stats['total_ruang'] }}</h3>
                    <p>Ruang / Lokasi</p>
                </div>
                <div class="small-box-icon"><i class="bi bi-door-open"></i></div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-info shadow-sm">
                <div class="inner">
                    <h3>{{ $stats['total_inventaris'] }}</h3>
                    <p>Jenis Inventaris</p>
                </div>
                <div class="small-box-icon"><i class="bi bi-box-seam"></i></div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-danger shadow-sm">
                <div class="inner">
                    <h3>{{ $stats['peminjam_aktif'] }}</h3>
                    <p>Peminjam Aktif</p>
                </div>
                <div class="small-box-icon"><i class="bi bi-person-badge"></i></div>
            </div>
        </div>
    @else
        <div class="col-lg-4 col-6">
            <div class="small-box text-bg-primary shadow-sm">
                <div class="inner">
                    <h3>{{ $stats['transaksi_berjalan'] }}</h3>
                    <p>Transaksi Dipinjam</p>
                </div>
                <div class="small-box-icon"><i class="bi bi-journal-text"></i></div>
            </div>
        </div>
        <div class="col-lg-4 col-6">
            <div class="small-box text-bg-success shadow-sm">
                <div class="inner">
                    <h3>{{ $stats['barang_tersedia'] }}</h3>
                    <p>Total Stok Tersedia</p>
                </div>
                <div class="small-box-icon"><i class="bi bi-box-seam"></i></div>
            </div>
        </div>
        <div class="col-lg-4 col-6">
            <div class="small-box text-bg-info shadow-sm">
                <div class="inner">
                    <h3>{{ $stats['transaksi_hari_ini'] }}</h3>
                    <p>Peminjaman Hari Ini</p>
                </div>
                <div class="small-box-icon"><i class="bi bi-calendar-check"></i></div>
            </div>
        </div>
    @endif
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4>Selamat Datang, {{ $user->nama_petugas }}!</h4>
                <p class="text-muted mb-0">Anda login sebagai <strong>{{ strtoupper($user->level->nama_level ?? '') }}</strong>. Gunakan menu di sebelah kiri untuk mengelola sistem pencatatan peminjaman sarana dan prasarana sekolah.</p>
            </div>
        </div>
    </div>
</div>
@endsection
