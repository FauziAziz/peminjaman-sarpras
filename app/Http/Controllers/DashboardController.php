<?php

namespace App\Http\Controllers;

use App\Models\Petugas;
use App\Models\Kategori;
use App\Models\Ruang;
use App\Models\Inventaris;
use App\Models\Peminjam;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $stats = [];

        if ($user->isAdmin()) {
            $stats = [
                'total_petugas' => Petugas::count(),
                'total_kategori' => Kategori::count(),
                'total_ruang' => Ruang::count(),
                'total_inventaris' => Inventaris::count(),
                'peminjam_aktif' => Peminjam::where('aktif', 1)->count(),
            ];
        } else {
            $stats = [
                'transaksi_berjalan' => Peminjaman::where('status_peminjaman', 'dipinjam')->count(),
                'barang_tersedia' => DB::selectOne("SELECT SUM(tersedia) AS total FROM v_stok_inventaris")->total ?? 0,
                'transaksi_hari_ini' => Peminjaman::whereDate('tanggal_pinjam', date('Y-m-d'))->count(),
            ];
        }

        return view('dashboard.index', compact('user', 'stats'));
    }
}
