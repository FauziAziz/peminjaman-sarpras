@extends('layouts.app')

@section('title', 'Data Petugas')
@section('header', 'Data Petugas')

@section('content')
@component('components.tabel-otomatis')
    @slot('slot')
        <a href="{{ route('petugas.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i> Tambah Petugas</a>
    @endslot

    <table class="table table-bordered table-striped align-middle">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Nama Petugas</th>
                <th>Username</th>
                <th>Level</th>
                <th width="15%" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($petugas as $item)
                <tr>
                    <td>{{ $petugas->firstItem() + $loop->index }}</td>
                    <td>{{ $item->nama_petugas }}</td>
                    <td><code>{{ $item->username }}</code></td>
                    <td><span class="badge bg-{{ $item->level->nama_level === 'admin' ? 'danger' : 'success' }}">{{ $item->level->nama_level }}</span></td>
                    <td class="text-center">
                        <a href="{{ route('petugas.edit', $item->id_petugas) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('petugas.destroy', $item->id_petugas) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">Tidak ada data petugas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-3">
        {{ $petugas->links() }}
    </div>
@endcomponent
@endsection

@push('scripts')
<script src="{{ asset('js/tabel-otomatis.js') }}"></script>
@endpush
