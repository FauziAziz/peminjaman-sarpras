@extends('layouts.app')

@section('title', 'Data Inventaris')
@section('header', 'Data Inventaris')

@section('content')
@component('components.tabel-otomatis')
    @slot('slot')
        <a href="{{ route('inventaris.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i> Tambah Inventaris</a>
    @endslot

    <table class="table table-bordered table-striped align-middle">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Ruang</th>
                <th class="text-center">Jumlah</th>
                <th>Kondisi</th>
                <th width="15%" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($inventaris as $item)
                <tr>
                    <td>{{ $inventaris->firstItem() + $loop->index }}</td>
                    <td><code>{{ $item->kode_inventaris }}</code></td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                    <td>{{ $item->ruang->nama_ruang ?? '-' }}</td>
                    <td class="text-center">{{ $item->jumlah }}</td>
                    <td><span class="badge bg-{{ $item->kondisi === 'baik' ? 'success' : 'warning' }}">{{ ucfirst($item->kondisi) }}</span></td>
                    <td class="text-center">
                        <a href="{{ route('inventaris.edit', $item->id_inventaris) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('inventaris.destroy', $item->id_inventaris) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus inventaris ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center text-muted">Tidak ada data inventaris.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-3">
        {{ $inventaris->links() }}
    </div>
@endcomponent
@endsection

@push('scripts')
<script src="{{ asset('js/tabel-otomatis.js') }}"></script>
@endpush
