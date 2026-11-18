@extends('layouts.app')

@section('title', 'Data Inventaris')
@section('header', 'Data Inventaris')

@section('content')
@component('components.tabel-otomatis')
    @slot('tombolAksi')
        <div class="d-flex gap-2">
            <select name="id_kategori" class="form-select form-select-sm filter-table" data-param="id_kategori">
                <option value="">Semua Kategori</option>
                @foreach(\App\Models\Kategori::all() as $k)
                    <option value="{{ $k->id_kategori }}" {{ request('id_kategori') == $k->id_kategori ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                @endforeach
            </select>
            <select name="kondisi" class="form-select form-select-sm filter-table" data-param="kondisi">
                <option value="">Semua Kondisi</option>
                <option value="baik" {{ request('kondisi') == 'baik' ? 'selected' : '' }}>Baik</option>
                <option value="rusak ringan" {{ request('kondisi') == 'rusak ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                <option value="rusak berat" {{ request('kondisi') == 'rusak berat' ? 'selected' : '' }}>Rusak Berat</option>
            </select>
            <a href="{{ route('inventaris.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i> Tambah</a>
        </div>
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
