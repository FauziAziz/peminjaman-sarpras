@extends('layouts.app')

@section('title', 'Daftar Pengembalian')
@section('header', 'Pengembalian Barang')

@section('content')
@component('components.tabel-otomatis')
    <table class="table table-bordered table-striped align-middle">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Peminjam</th>
                <th>Tgl Pinjam</th>
                <th>Barang</th>
                <th width="15%" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($peminjaman as $item)
                <tr>
                    <td>{{ $peminjaman->firstItem() + $loop->index }}</td>
                    <td>{{ $item->peminjam->nama_peminjam }}<br><small class="text-muted">{{ $item->peminjam->jabatan }}</small></td>
                    <td>{{ date('d-m-Y', strtotime($item->tanggal_pinjam)) }}</td>
                    <td>
                        <ul class="list-unstyled mb-0 small">
                            @foreach($item->detailPinjam as $detail)
                                <li>{{ $detail->inventaris->nama }} ({{ $detail->jumlah }})</li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="text-center">
                        <form action="{{ route('pengembalian.update', $item->id_peminjaman) }}" method="POST" onsubmit="return confirm('Konfirmasi pengembalian barang untuk peminjam ini?');">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm"><i class="bi bi-check-circle me-1"></i> Kembali</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">Tidak ada transaksi yang harus dikembalikan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-3">
        {{ $peminjaman->links() }}
    </div>
@endcomponent
@endsection

@push('scripts')
<script src="{{ asset('js/tabel-otomatis.js') }}"></script>
@endpush
