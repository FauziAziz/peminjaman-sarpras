<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Services\RiwayatService;
use App\Exports\RiwayatExport;
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
        $dari = $request->input('dari', date('Y-m-01'));
        $sampai = $request->input('sampai', date('Y-m-d'));
        $status = $request->input('status', 'semua');
        $peminjam = $request->input('peminjam');
        $idKategori = $request->input('id_kategori');

        $kategoriList = Kategori::orderBy('nama_kategori')->get();
        $riwayat = [];
        $errorMessage = null;

        try {
            $riwayat = $this->service->ambilRiwayat($dari, $sampai, $status, $peminjam, $idKategori);
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            if (str_contains($msg, 'SQLSTATE[45000]')) {
                $parts = explode(':', $msg);
                $msg = trim(end($parts));
            }
            $errorMessage = $msg;
        }

        return view('riwayat.index', compact('riwayat', 'kategoriList', 'dari', 'sampai', 'status', 'peminjam', 'idKategori', 'errorMessage'));
    }

    public function export(Request $request)
    {
        $dari = $request->input('dari', date('Y-m-01'));
        $sampai = $request->input('sampai', date('Y-m-d'));
        $status = $request->input('status', 'semua');
        $peminjam = $request->input('peminjam');
        $idKategori = $request->input('id_kategori');
        $format = $request->input('format', 'xlsx');

        try {
            $data = $this->service->ambilRiwayat($dari, $sampai, $status, $peminjam, $idKategori);
            $filename = "riwayat-peminjaman_{$dari}_sd_{$sampai}." . ($format === 'csv' ? 'csv' : 'xlsx');
            
            $writerType = $format === 'csv' ? \Maatwebsite\Excel\Excel::CSV : \Maatwebsite\Excel\Excel::XLSX;

            return Excel::download(new RiwayatExport($data), $filename, $writerType);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal melakukan export data: ' . $e->getMessage());
        }
    }
}
