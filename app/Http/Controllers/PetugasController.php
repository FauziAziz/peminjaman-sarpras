<?php

namespace App\Http\Controllers;

use App\Http\Requests\PetugasRequest;
use App\Models\Level;
use App\Models\Petugas;
use App\Services\PetugasService;
use Illuminate\Http\Request;

class PetugasController extends Controller
{
    protected PetugasService $service;

    public function __construct(PetugasService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $petugas = Petugas::with('level')
            ->when($search, function ($query, $search) {
                $query->where('nama_petugas', 'like', "%{$search}%")
                      ->orWhere('username', 'like', "%{$search}%");
            })
            ->orderBy('id_petugas', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('petugas.index', compact('petugas', 'search'));
    }

    public function create()
    {
        $levels = Level::all();
        return view('petugas.create', compact('levels'));
    }

    public function store(PetugasRequest $request)
    {
        try {
            $this->service->simpan($request->validated());
            return redirect()->route('petugas.index')->with('success', 'Data petugas berhasil disimpan.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function edit(Petugas $petugas)
    {
        $levels = Level::all();
        return view('petugas.edit', compact('petugas', 'levels'));
    }

    public function update(PetugasRequest $request, Petugas $petugas)
    {
        try {
            $this->service->perbarui($petugas, $request->validated());
            return redirect()->route('petugas.index')->with('success', 'Data petugas berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function destroy(Petugas $petugas)
    {
        if (auth()->id() === $petugas->id_petugas) {
            return back()->with('error', 'Anda tidak dapat menghapus akun yang sedang digunakan.');
        }

        try {
            $this->service->hapus($petugas);
            return redirect()->route('petugas.index')->with('success', 'Data petugas berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
