<?php

namespace App\Http\Controllers;

use App\Http\Requests\PeminjamanRequest;
use App\Models\Peminjam;
use App\Models\Peminjaman;
use App\Services\PeminjamanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    protected PeminjamanService $service;

    public function __construct(PeminjamanService $service)
    {
        $this->service = $service;
    }

    public function create()
    {
        $peminjam = Peminjam::where('aktif', 1)->orderBy('nama_peminjam')->get();
        $inventaris = DB::table('v_stok_inventaris')->where('tersedia', '>', 0)->orderBy('nama')->get();

        return view('peminjaman.create', compact('peminjam', 'inventaris'));
    }

    public function store(PeminjamanRequest $request)
    {
        try {
            $validated = $request->validated();
            $this->service->buatPeminjaman(
                $validated['id_peminjam'],
                auth()->id(),
                $validated['tanggal_pinjam'],
                $validated['items']
            );

            return redirect()->route('peminjaman.create')->with('success', 'Peminjaman berhasil dicatat.');
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            // Clean SQLSTATE message prefix if exists
            if (str_contains($msg, 'SQLSTATE[45000]')) {
                $parts = explode(':', $msg);
                $msg = trim(end($parts));
            }
            return back()->withInput()->with('error', $msg);
        }
    }

    public function pengembalianIndex(Request $request)
    {
        $search = $request->input('search');
        $peminjaman = Peminjaman::with(['peminjam', 'petugas', 'detailPinjam.inventaris'])
            ->where('status_peminjaman', 'dipinjam')
            ->when($search, function ($query, $search) {
                $query->whereHas('peminjam', function ($q) use ($search) {
                    $q->where('nama_peminjam', 'like', "%{$search}%");
                });
            })
            ->orderBy('id_peminjaman', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('peminjaman.pengembalian', compact('peminjaman', 'search'));
    }

    public function kembalikan(Request $request, Peminjaman $peminjaman)
    {
        try {
            $tanggalKembali = $request->input('tanggal_kembali', date('Y-m-d'));
            $this->service->kembalikanPeminjaman($peminjaman->id_peminjaman, $tanggalKembali);

            return redirect()->route('pengembalian.index')->with('success', 'Pengembalian barang berhasil dikonfirmasi.');
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            if (str_contains($msg, 'SQLSTATE[45000]')) {
                $parts = explode(':', $msg);
                $msg = trim(end($parts));
            }
            return back()->with('error', $msg);
        }
    }
}
