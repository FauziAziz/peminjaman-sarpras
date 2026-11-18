@extends('layouts.app')

@section('title', 'Tambah Petugas')
@section('header', 'Tambah Petugas')

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

        <form action="{{ route('petugas.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama Petugas</label>
                <input type="text" name="nama_petugas" class="form-control" value="{{ old('nama_petugas') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" value="{{ old('username') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Level</label>
                <select name="id_level" class="form-select" required>
                    @foreach($levels as $level)
                        <option value="{{ $level->id_level }}" {{ old('id_level') == $level->id_level ? 'selected' : '' }}>{{ ucfirst($level->nama_level) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="d-flex justify-content-between">
                <a href="{{ route('petugas.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
