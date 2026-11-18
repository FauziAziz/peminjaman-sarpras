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
                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalKembali{{ $item->id_peminjaman }}">
                            <i class="bi bi-check-circle me-1"></i> Confirm
                        </button>

                        <div class="modal fade" id="modalKembali{{ $item->id_peminjaman }}" tabindex="-1">
                            <div class="modal-dialog">
                                <form action="{{ route('pengembalian.update', $item->id_peminjaman) }}" method="POST">
                                    @csrf
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Konfirmasi Pengembalian</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body text-start">
                                            <p>Peminjam: <strong>{{ $item->peminjam->nama_peminjam }}</strong></p>
                                            <div class="mb-3">
                                                <label class="form-label">Kondisi Barang yang Kembali</label>
                                                <select name="kondisi" class="form-select" required>
                                                    <option value="baik">Baik</option>
                                                    <option value="rusak ringan">Rusak Ringan</option>
                                                    <option value="rusak berat">Rusak Berat</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-success">Confirm</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
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
