@extends('layouts.app')

@section('title', 'Data Peminjam')
@section('header', 'Data Peminjam')

@section('content')
@component('components.tabel-otomatis')
    @slot('slot')
        <a href="{{ route('peminjam.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i> Tambah Peminjam</a>
    @endslot

    <table class="table table-bordered table-striped align-middle">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Nama Peminjam</th>
                <th>Jabatan</th>
                <th class="text-center">Status</th>
                @if(auth()->user()->isAdmin())
                    <th width="15%" class="text-center">Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse($peminjam as $item)
                <tr>
                    <td>{{ $peminjam->firstItem() + $loop->index }}</td>
                    <td>{{ $item->nama_peminjam }}</td>
                    <td>{{ $item->jabatan }}</td>
                    <td class="text-center">
                        <span class="badge bg-{{ $item->aktif ? 'success' : 'secondary' }}">{{ $item->aktif ? 'Aktif' : 'Nonaktif' }}</span>
                    </td>
                    @if(auth()->user()->isAdmin())
                        <td class="text-center">
                            <a href="{{ route('peminjam.edit', $item->id_peminjam) }}" class="btn btn-warning btn-sm" title="Ubah"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('peminjam.toggle', $item->id_peminjam) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-{{ $item->aktif ? 'secondary' : 'success' }} btn-sm" title="{{ $item->aktif ? 'Nonaktifkan' : 'Aktifkan' }}">
                                    <i class="bi bi-power"></i>
                                </button>
                            </form>
                        </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="{{ auth()->user()->isAdmin() ? 5 : 4 }}" class="text-center text-muted">Tidak ada data peminjam.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-3">
        {{ $peminjam->links() }}
    </div>
@endcomponent
@endsection

@push('scripts')
<script src="{{ asset('js/tabel-otomatis.js') }}"></script>
@endpush
