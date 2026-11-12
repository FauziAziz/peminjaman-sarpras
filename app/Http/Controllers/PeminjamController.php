<?php

namespace App\Http\Controllers;

use App\Http\Requests\PeminjamRequest;
use App\Models\Peminjam;
use App\Services\PeminjamService;
use Illuminate\Http\Request;

class PeminjamController extends Controller
{
    protected PeminjamService $service;

    public function __construct(PeminjamService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $peminjam = Peminjam::when($search, function ($query, $search) {
                $query->where('nama_peminjam', 'like', "%{$search}%")
                      ->orWhere('jabatan', 'like', "%{$search}%");
            })
            ->orderBy('id_peminjam', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('peminjam.index', compact('peminjam', 'search'));
    }

    public function create()
    {
        return view('peminjam.create');
    }

    public function store(PeminjamRequest $request)
    {
        try {
            $this->service->simpan($request->validated());
            return redirect()->route('peminjam.index')->with('success', 'Data peminjam berhasil disimpan.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function edit(Peminjam $peminjam)
    {
        if (auth()->user()->isOperator()) {
            abort(403, 'Operator tidak diizinkan mengubah peminjam.');
        }

        return view('peminjam.edit', compact('peminjam'));
    }

    public function update(PeminjamRequest $request, Peminjam $peminjam)
    {
        if (auth()->user()->isOperator()) {
            abort(403, 'Operator tidak diizinkan mengubah peminjam.');
        }

        try {
            $this->service->perbarui($peminjam, $request->validated());
            return redirect()->route('peminjam.index')->with('success', 'Data peminjam berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function toggleAktif(Peminjam $peminjam)
    {
        if (auth()->user()->isOperator()) {
            abort(403, 'Operator tidak diizinkan menonaktifkan peminjam.');
        }

        try {
            $this->service->toggleAktif($peminjam);
            return redirect()->route('peminjam.index')->with('success', 'Status peminjam berhasil diubah.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
