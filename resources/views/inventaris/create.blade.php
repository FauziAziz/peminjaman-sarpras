@extends('layouts.app')

@section('title', 'Tambah Inventaris')
@section('header', 'Tambah Inventaris')

@section('content')
<div class="card shadow-sm" style="max-width: 800px;">
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

        <form action="{{ route('inventaris.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kategori</label>
                    <select name="id_kategori" id="id_kategori" class="form-select" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategori as $kat)
                            <option value="{{ $kat->id_kategori }}" {{ old('id_kategori', $selectedKategori) == $kat->id_kategori ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kode Inventaris</label>
                    <input type="text" name="kode_inventaris" id="kode_inventaris" class="form-control" value="{{ old('kode_inventaris', $generatedKode) }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Barang</label>
                <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Ruang / Lokasi</label>
                    <select name="id_ruang" class="form-select">
                        <option value="">-- Tanpa Ruang --</option>
                        @foreach($ruang as $rg)
                            <option value="{{ $rg->id_ruang }}" {{ old('id_ruang') == $rg->id_ruang ? 'selected' : '' }}>{{ $rg->nama_ruang }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Register</label>
                    <input type="date" name="tanggal_register" class="form-control" value="{{ old('tanggal_register', date('Y-m-d')) }}" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jumlah</label>
                    <input type="number" name="jumlah" class="form-control" value="{{ old('jumlah', 0) }}" min="0" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kondisi</label>
                    <select name="kondisi" class="form-select" required>
                        <option value="baik" {{ old('kondisi') == 'baik' ? 'selected' : '' }}>Baik</option>
                        <option value="rusak ringan" {{ old('kondisi') == 'rusak ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                        <option value="rusak berat" {{ old('kondisi') == 'rusak berat' ? 'selected' : '' }}>Rusak Berat</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="2">{{ old('keterangan') }}</textarea>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('inventaris.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('id_kategori').addEventListener('change', function() {
    const id = this.value;
    if (!id) return;
    
    fetch(`{{ route('inventaris.kode') }}?id_kategori=${id}`)
        .then(res => res.json())
        .then(data => {
            document.getElementById('kode_inventaris').value = data.kode;
        });
});
</script>
@endpush
