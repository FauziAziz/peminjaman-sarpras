@extends('layouts.app')

@section('title', 'Ubah Ruang')
@section('header', 'Ubah Ruang')

@section('content')
<div class="card shadow-sm" style="max-width: 600px;">
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

        <form action="{{ route('ruang.update', $ruang->id_ruang) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Kode Ruang</label>
                <input type="text" name="kode_ruang" class="form-control" value="{{ old('kode_ruang', $ruang->kode_ruang) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Nama Ruang</label>
                <input type="text" name="nama_ruang" class="form-control" value="{{ old('nama_ruang', $ruang->nama_ruang) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan', $ruang->keterangan) }}</textarea>
            </div>
            <div class="d-flex justify-content-between">
                <a href="{{ route('ruang.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Perbarui</button>
            </div>
        </form>
    </div>
</div>
@endsection
