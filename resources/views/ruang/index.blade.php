@extends('layouts.app')

@section('title', 'Data Ruang')
@section('header', 'Data Ruang')

@section('content')
@component('components.tabel-otomatis')
    @slot('slot')
        <a href="{{ route('ruang.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i> Tambah Ruang</a>
    @endslot

    <table class="table table-bordered table-striped align-middle">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Kode Ruang</th>
                <th>Nama Ruang</th>
                <th>Keterangan</th>
                <th width="15%" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ruang as $item)
                <tr>
                    <td>{{ $ruang->firstItem() + $loop->index }}</td>
                    <td><code>{{ $item->kode_ruang }}</code></td>
                    <td>{{ $item->nama_ruang }}</td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
                    <td class="text-center">
                        <a href="{{ route('ruang.edit', $item->id_ruang) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('ruang.destroy', $item->id_ruang) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus ruang ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">Tidak ada data ruang.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-3">
        {{ $ruang->links() }}
    </div>
@endcomponent
@endsection

@push('scripts')
<script src="{{ asset('js/tabel-otomatis.js') }}"></script>
@endpush
