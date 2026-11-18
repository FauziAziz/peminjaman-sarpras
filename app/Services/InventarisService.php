<?php

namespace App\Services;

use App\Models\Inventaris;
use App\Models\Kategori;

class InventarisService
{
    public function generateKode(int $idKategori): string
    {
        $kategori = Kategori::find($idKategori);
        $prefix = $kategori ? $kategori->kode_kategori : 'BRG';
        
        $last = Inventaris::where('id_kategori', $idKategori)->orderBy('id_inventaris', 'desc')->first();
        $nextNumber = 1;

        if ($last) {
            $parts = explode('-', $last->kode_inventaris);
            $numPart = end($parts);
            if (is_numeric($numPart)) {
                $nextNumber = intval($numPart) + 1;
            }
        }

        return sprintf('%s-%03d', $prefix, $nextNumber);
    }

    public function simpan(array $data, int $idPetugas): Inventaris
    {
        $data['id_petugas'] = $idPetugas;
        return Inventaris::create($data);
    }

    public function perbarui(Inventaris $inventaris, array $data): bool
    {
        return $inventaris->update($data);
    }

    public function hapus(Inventaris $inventaris): bool
    {
        if ($inventaris->detailPinjam()->count() > 0) {
            throw new \Exception('Inventaris tidak dapat dihapus karena sudah pernah digunakan dalam transaksi peminjaman.');
        }

        return $inventaris->delete();
    }
}
