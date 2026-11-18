<?php

namespace App\Http\Controllers;

use App\Http\Requests\KategoriRequest;
use App\Models\Kategori;
use App\Services\KategoriService;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    protected KategoriService $service;

    public function __construct(KategoriService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $kategori = Kategori::when($search, function ($query, $search) {
                $query->where('nama_kategori', 'like', "%{$search}%")
                      ->orWhere('kode_kategori', 'like', "%{$search}%");
            })
            ->orderBy('id_kategori', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('kategori.index', compact('kategori', 'search'));
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(KategoriRequest $request)
    {
        try {
            $this->service->simpan($request->validated());
            return redirect()->route('kategori.index')->with('success', 'Kategori berhasil disimpan.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function edit(Kategori $kategori)
    {
        return view('kategori.edit', compact('kategori'));
    }

    public function update(KategoriRequest $request, Kategori $kategori)
    {
        try {
            $this->service->perbarui($kategori, $request->validated());
            return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function destroy(Kategori $kategori)
    {
        try {
            $this->service->hapus($kategori);
            return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
