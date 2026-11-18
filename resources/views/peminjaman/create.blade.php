@extends('layouts.app')

@section('title', 'Peminjaman Baru')
@section('header', 'Peminjaman Baru')

@push('styles')
<link rel="stylesheet" href="{{ asset('vendor/tom-select/tom-select.bootstrap5.min.css') }}">
@endpush

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger py-2 small mb-3">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('peminjaman.store') }}" method="POST" id="formPeminjaman">
            @csrf
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Peminjam</label>
                    <div class="input-group">
                        <select name="id_peminjam" id="id_peminjam" class="form-select" required>
                            <option value="">-- Pilih Peminjam --</option>
                            @foreach($peminjam as $p)
                                <option value="{{ $p->id_peminjam }}" data-jabatan="{{ $p->jabatan }}" {{ old('id_peminjam') == $p->id_peminjam ? 'selected' : '' }}>{{ $p->nama_peminjam }} ({{ $p->jabatan }})</option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalTambahPeminjam"><i class="bi bi-plus-lg"></i> Baru</button>
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Jabatan</label>
                    <input type="text" id="jabatan_peminjam" class="form-control" readonly placeholder="Terisi otomatis">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tanggal Pinjam</label>
                    <input type="date" name="tanggal_pinjam" class="form-control" value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" required>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Barang yang Dipinjam</h5>
                <button type="button" class="btn btn-success btn-sm" id="tambahBaris"><i class="bi bi-plus-circle me-1"></i> Tambah Barang</button>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered align-middle" id="tabelBarang">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Barang (Stok Tersedia)</th>
                            <th width="20%">Jumlah</th>
                            <th width="10%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="containerBaris">
                        <!-- Baris dinamis -->
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-primary btn-lg"><i class="bi bi-save me-1"></i> Simpan Peminjaman</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Tambah Cepat Peminjam -->
<div class="modal fade" id="modalTambahPeminjam" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Peminjam Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama Peminjam</label>
                    <input type="text" id="cepat_nama" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jabatan</label>
                    <input type="text" id="cepat_jabatan" class="form-control" placeholder="Contoh: Guru, Siswa" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="simpanPeminjamCepat">Simpan & Pilih</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('vendor/tom-select/tom-select.complete.min.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const inventarisList = @json($inventaris);
    let barisIndex = 0;

    const selectPeminjam = new TomSelect('#id_peminjam', {
        create: false,
        sortField: {field: "text", direction: "asc"}
    });

    selectPeminjam.on('change', function(value) {
        const selectedOpt = document.querySelector(`#id_peminjam option[value="${value}"]`);
        const jabatan = selectedOpt ? selectedOpt.getAttribute('data-jabatan') : '';
        document.getElementById('jabatan_peminjam').value = jabatan;
    });

    function tambahBarisBarang(idInv = '', jml = 1) {
        const tbody = document.getElementById('containerBaris');
        const tr = document.createElement('tr');
        tr.className = 'baris-item';
        
        let optionsHtml = '<option value="">-- Pilih Barang --</option>';
        inventarisList.forEach(inv => {
            const selected = inv.id_inventaris == idInv ? 'selected' : '';
            optionsHtml += `<option value="${inv.id_inventaris}" data-tersedia="${inv.tersedia}" ${selected}>${inv.nama} (Stok: ${inv.tersedia})</option>`;
        });

        tr.innerHTML = `
            <td class="nomor text-center"></td>
            <td>
                <select name="items[${barisIndex}][id_inventaris]" class="form-select select-barang" required>
                    ${optionsHtml}
                </select>
            </td>
            <td>
                <input type="number" name="items[${barisIndex}][jumlah]" class="form-control input-jumlah" value="${jml}" min="1" required>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm hapusBaris"><i class="bi bi-trash"></i></button>
            </td>
        `;

        tbody.appendChild(tr);
        
        // Inisialisasi TomSelect untuk barang baru
        new TomSelect(tr.querySelector('.select-barang'), {
            create: false,
            sortField: {field: "text", direction: "asc"}
        });

        barisIndex++;
        perbaruiNomor();
    }

    function perbaruiNomor() {
        document.querySelectorAll('#containerBaris .baris-item').forEach((row, idx) => {
            row.querySelector('.nomor').textContent = idx + 1;
        });
    }

    document.getElementById('tambahBaris').addEventListener('click', function() {
        tambahBarisBarang();
    });

    document.getElementById('containerBaris').addEventListener('click', function(e) {
        if (e.target.closest('.hapusBaris')) {
            e.target.closest('tr').remove();
            perbaruiNomor();
        }
    });

    // Tambah baris awal 1
    tambahBarisBarang();

    // Tambah cepat peminjam via AJAX
    document.getElementById('simpanPeminjamCepat').addEventListener('click', function() {
        const nama = document.getElementById('cepat_nama').value;
        const jabatan = document.getElementById('cepat_jabatan').value;

        if (!nama || !jabatan) {
            alert('Nama dan jabatan wajib diisi.');
            return;
        }

        fetch('{{ route("peminjam.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ nama_peminjam: nama, jabatan: jabatan })
        })
        .then(res => res.json())
        .then(data => {
            // Reload atau tambah manual ke select
            location.reload();
        })
        .catch(err => {
            alert('Gagal menambah peminjam.');
        });
    });
});
</script>
@endpush
