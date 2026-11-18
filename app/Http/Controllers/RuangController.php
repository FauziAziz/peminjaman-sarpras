<?php

namespace App\Http\Controllers;

use App\Http\Requests\RuangRequest;
use App\Models\Ruang;
use App\Services\RuangService;
use Illuminate\Http\Request;

class RuangController extends Controller
{
    protected RuangService $service;

    public function __construct(RuangService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $ruang = Ruang::when($search, function ($query, $search) {
                $query->where('nama_ruang', 'like', "%{$search}%")
                      ->orWhere('kode_ruang', 'like', "%{$search}%");
            })
            ->orderBy('id_ruang', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('ruang.index', compact('ruang', 'search'));
    }

    public function create()
    {
        return view('ruang.create');
    }

    public function store(RuangRequest $request)
    {
        try {
            $this->service->simpan($request->validated());
            return redirect()->route('ruang.index')->with('success', 'Ruang berhasil disimpan.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function edit(Ruang $ruang)
    {
        return view('ruang.edit', compact('ruang'));
    }

    public function update(RuangRequest $request, Ruang $ruang)
    {
        try {
            $this->service->perbarui($ruang, $request->validated());
            return redirect()->route('ruang.index')->with('success', 'Ruang berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function destroy(Ruang $ruang)
    {
        try {
            $this->service->hapus($ruang);
            return redirect()->route('ruang.index')->with('success', 'Ruang berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
