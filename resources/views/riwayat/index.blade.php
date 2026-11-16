@extends('layouts.app')

@section('title', 'Riwayat Peminjaman')
@section('header', 'Riwayat Peminjaman & Export')

@section('content')
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ route('riwayat.index') }}" method="GET" id="formFilter">
            <div class="row g-3 mb-3">
                <div class="col-md-12">
                    <label class="form-label fw-bold">Rentang Waktu:</label>
                    <div class="btn-group d-flex flex-wrap gap-1 mb-2" role="group">
                        <button type="button" class="btn btn-outline-secondary btn-sm range-btn" data-range="today">Hari Ini</button>
                        <button type="button" class="btn btn-outline-secondary btn-sm range-btn" data-range="7days">7 Hari</button>
                        <button type="button" class="btn btn-outline-secondary btn-sm range-btn" data-range="30days">30 Hari</button>
                        <button type="button" class="btn btn-outline-secondary btn-sm range-btn" data-range="thismonth">Bulan Ini</button>
                        <button type="button" class="btn btn-outline-secondary btn-sm range-btn" data-range="1year">1 Tahun</button>
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Dari Tanggal</label>
                    <input type="date" name="dari" id="dari" class="form-control" value="{{ $dari }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Sampai Tanggal</label>
                    <input type="date" name="sampai" id="sampai" class="form-control" value="{{ $sampai }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="semua" {{ $status == 'semua' ? 'selected' : '' }}>Semua</option>
                        <option value="dipinjam" {{ $status == 'dipinjam' ? 'selected' : '' }}>Sedang Dipinjam</option>
                        <option value="kembali" {{ $status == 'kembali' ? 'selected' : '' }}>Sudah Dikembalikan</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Kategori Barang</label>
                    <select name="id_kategori" class="form-select">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoriList as $kat)
                            <option value="{{ $kat->id_kategori }}" {{ $idKategori == $kat->id_kategori ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Cari Peminjam</label>
                    <input type="text" name="peminjam" class="form-control" value="{{ $peminjam }}" placeholder="Nama peminjam...">
                </div>
                <div class="col-md-8 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-filter me-1"></i> Terapkan Filter</button>
                    <a href="{{ route('riwayat.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-counterclockwise me-1"></i> Reset</a>
                    
                    <div class="ms-auto d-flex gap-2">
                        <a href="{{ route('riwayat.export', array_merge(request()->all(), ['format' => 'csv'])) }}" class="btn btn-success"><i class="bi bi-file-earmark-excel me-1"></i> Export CSV</a>
                        <a href="{{ route('riwayat.export', array_merge(request()->all(), ['format' => 'xlsx'])) }}" class="btn btn-dark"><i class="bi bi-file-earmark-spreadsheet me-1"></i> Export Excel</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@if($errorMessage)
    <div class="alert alert-danger">{{ $errorMessage }}</div>
@else
    <div class="card shadow-sm">
        <div class="card-body">
            <p class="text-muted small mb-3">Ditemukan {{ count($riwayat) }} data riwayat.</p>
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Tanggal Pinjam</th>
                            <th>Peminjam</th>
                            <th>Barang</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-center">Status</th>
                            <th>Tanggal Kembali</th>
                            <th>Petugas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayat as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ date('d-m-Y', strtotime($item->tanggal_pinjam)) }}</td>
                                <td>{{ $item->nama_peminjam }}<br><small class="text-muted">{{ $item->jabatan }}</small></td>
                                <td>{{ $item->nama_barang }}</td>
                                <td class="text-center">{{ $item->jumlah }}</td>
                                <td class="text-center">
                                    <span class="badge {{ $item->status_peminjaman === 'kembali' ? 'badge-status-kembali' : 'badge-status-dipinjam' }}">{{ $item->status_peminjaman === 'kembali' ? 'Dikembalikan' : 'Dipinjam' }}</span>
                                </td>
                                <td>{{ $item->tanggal_kembali ? date('d-m-Y', strtotime($item->tanggal_kembali)) : '-' }}</td>
                                <td>{{ $item->nama_petugas }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">Tidak ada data riwayat pada rentang waktu ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dariInput = document.getElementById('dari');
    const sampaiInput = document.getElementById('sampai');

    document.querySelectorAll('.range-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const range = this.getAttribute('data-range');
            const today = new Date();
            let dari = new Date();

            if (range === 'today') {
                dari = today;
            } else if (range === '7days') {
                dari.setDate(today.getDate() - 7);
            } else if (range === '30days') {
                dari.setDate(today.getDate() - 30);
            } else if (range === 'thismonth') {
                dari = new Date(today.getFullYear(), today.getMonth(), 1);
            } else if (range === '1year') {
                dari.setFullYear(today.getFullYear() - 1);
            }

            dariInput.value = dari.toISOString().split('T')[0];
            sampaiInput.value = today.toISOString().split('T')[0];
            document.getElementById('formFilter').submit();
        });
    });
});
</script>
@endpush
