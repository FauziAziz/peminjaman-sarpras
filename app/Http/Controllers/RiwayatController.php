<?php

namespace App\Http\Controllers;

use App\Exports\RiwayatExport;
use App\Models\Kategori;
use App\Services\RiwayatService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RiwayatController extends Controller
{
    protected RiwayatService $service;

    public function __construct(RiwayatService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        // Default tanggal: awal bulan ini sampai hari ini
        $dari = $request->input('dari', date('Y-m-01'));
        $sampai = $request->input('sampai', date('Y-m-d'));
        $status = $request->input('status', 'semua');
        $peminjam = $request->input('peminjam');
        $idKategori = $request->input('id_kategori');

        $kategori = Kategori::all();
        $riwayat = [];
        $error = null;

        try {
            $riwayat = $this->service->ambilRiwayat($dari, $sampai, $status, $peminjam, $idKategori);
        } catch (\Exception $e) {
            $error = $e->getMessage();
        }

        if ($request->has('export')) {
            $format = $request->input('export');
            $filename = "riwayat-peminjaman_{$dari}_sd_{$sampai}";

            if ($format === 'csv') {
                return Excel::download(new RiwayatExport($riwayat), "{$filename}.csv", \Maatwebsite\Excel\Excel::CSV, [
                    'Content-Type' => 'text/csv; charset=UTF-8',
                ]);
            }

            if ($format === 'xlsx') {
                return Excel::download(new RiwayatExport($riwayat), "{$filename}.xlsx");
            }
        }

        return view('riwayat.index', compact('riwayat', 'kategori', 'dari', 'sampai', 'status', 'peminjam', 'idKategori', 'error'));
    }
}
