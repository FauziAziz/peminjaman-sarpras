@extends('layouts.app')

@section('title', 'Data Kategori')
@section('header', 'Data Kategori')

@section('content')
@component('components.tabel-otomatis')
    @slot('slot')
        <a href="{{ route('kategori.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i> Tambah Kategori</a>
    @endslot

    <table class="table table-bordered table-striped align-middle">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Kode</th>
                <th>Nama Kategori</th>
                <th>Keterangan</th>
                <th width="15%" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kategori as $item)
                <tr>
                    <td>{{ $kategori->firstItem() + $loop->index }}</td>
                    <td><code>{{ $item->kode_kategori }}</code></td>
                    <td>{{ $item->nama_kategori }}</td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
                    <td class="text-center">
                        <a href="{{ route('kategori.edit', $item->id_kategori) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('kategori.destroy', $item->id_kategori) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">Tidak ada data kategori.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-3">
        {{ $kategori->links() }}
    </div>
@endcomponent
@endsection

@push('scripts')
<script src="{{ asset('js/tabel-otomatis.js') }}"></script>
@endpush
