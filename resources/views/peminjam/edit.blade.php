@extends('layouts.app')

@section('title', 'Ubah Peminjam')
@section('header', 'Ubah Peminjam')

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

        <form action="{{ route('peminjam.update', $peminjam->id_peminjam) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Nama Peminjam</label>
                <input type="text" name="nama_peminjam" class="form-control" value="{{ old('nama_peminjam', $peminjam->nama_peminjam) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Jabatan</label>
                <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan', $peminjam->jabatan) }}" required>
            </div>
            <div class="d-flex justify-content-between">
                <a href="{{ route('peminjam.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Perbarui</button>
            </div>
        </form>
    </div>
</div>
@endsection
