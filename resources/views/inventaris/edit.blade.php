@extends('layouts.app')

@section('title', 'Ubah Inventaris')
@section('header', 'Ubah Inventaris')

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

        <form action="{{ route('inventaris.update', $inventaris->id_inventaris) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kategori</label>
                    <select name="id_kategori" class="form-select" required disabled>
                        @foreach($kategori as $kat)
                            <option value="{{ $kat->id_kategori }}" {{ old('id_kategori', $inventaris->id_kategori) == $kat->id_kategori ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="id_kategori" value="{{ $inventaris->id_kategori }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kode Inventaris</label>
                    <input type="text" name="kode_inventaris" class="form-control" value="{{ old('kode_inventaris', $inventaris->kode_inventaris) }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Barang</label>
                <input type="text" name="nama" class="form-control" value="{{ old('nama', $inventaris->nama) }}" required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Ruang / Lokasi</label>
                    <select name="id_ruang" class="form-select">
                        <option value="">-- Tanpa Ruang --</option>
                        @foreach($ruang as $rg)
                            <option value="{{ $rg->id_ruang }}" {{ old('id_ruang', $inventaris->id_ruang) == $rg->id_ruang ? 'selected' : '' }}>{{ $rg->nama_ruang }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Register</label>
                    <input type="date" name="tanggal_register" class="form-control" value="{{ old('tanggal_register', $inventaris->tanggal_register) }}" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jumlah</label>
                    <input type="number" name="jumlah" class="form-control" value="{{ old('jumlah', $inventaris->jumlah) }}" min="0" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kondisi</label>
                    <select name="kondisi" class="form-select" required>
                        <option value="baik" {{ old('kondisi', $inventaris->kondisi) == 'baik' ? 'selected' : '' }}>Baik</option>
                        <option value="rusak ringan" {{ old('kondisi', $inventaris->kondisi) == 'rusak ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                        <option value="rusak berat" {{ old('kondisi', $inventaris->kondisi) == 'rusak berat' ? 'selected' : '' }}>Rusak Berat</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="2">{{ old('keterangan', $inventaris->keterangan) }}</textarea>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('inventaris.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Perbarui</button>
            </div>
        </form>
    </div>
</div>
@endsection
