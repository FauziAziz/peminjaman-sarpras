<?php

namespace App\Http\Controllers;

use App\Http\Requests\InventarisRequest;
use App\Models\Inventaris;
use App\Models\Kategori;
use App\Models\Ruang;
use App\Services\InventarisService;
use Illuminate\Http\Request;

class InventarisController extends Controller
{
    protected InventarisService $service;

    public function __construct(InventarisService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $inventaris = Inventaris::with(['kategori', 'ruang', 'petugas'])
            ->when($search, function ($query, $search) {
                $query->where('nama', 'like', "%{$search}%")
                      ->orWhere('kode_inventaris', 'like', "%{$search}%");
            })
            ->orderBy('id_inventaris', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('inventaris.index', compact('inventaris', 'search'));
    }

    public function create(Request $request)
    {
        $kategori = Kategori::all();
        $ruang = Ruang::all();
        $selectedKategori = $request->input('id_kategori', $kategori->first()?->id_kategori);
        $generatedKode = $selectedKategori ? $this->service->generateKode($selectedKategori) : '';

        return view('inventaris.create', compact('kategori', 'ruang', 'selectedKategori', 'generatedKode'));
    }

    public function getKode(Request $request)
    {
        $idKategori = $request->input('id_kategori');
        $kode = $this->service->generateKode($idKategori);
        return response()->json(['kode' => $kode]);
    }

    public function store(InventarisRequest $request)
    {
        try {
            $this->service->simpan($request->validated(), auth()->id());
            return redirect()->route('inventaris.index')->with('success', 'Data inventaris berhasil disimpan.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function edit(Inventaris $inventaris)
    {
        $kategori = Kategori::all();
        $ruang = Ruang::all();
        return view('inventaris.edit', compact('inventaris', 'kategori', 'ruang'));
    }

    public function update(InventarisRequest $request, Inventaris $inventaris)
    {
        try {
            $this->service->perbarui($inventaris, $request->validated());
            return redirect()->route('inventaris.index')->with('success', 'Data inventaris berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function destroy(Inventaris $inventaris)
    {
        try {
            $this->service->hapus($inventaris);
            return redirect()->route('inventaris.index')->with('success', 'Data inventaris berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
