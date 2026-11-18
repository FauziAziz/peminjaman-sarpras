<?php

namespace App\Services;

use App\Models\Kategori;

class KategoriService
{
    public function simpan(array $data): Kategori
    {
        return Kategori::create($data);
    }

    public function perbarui(Kategori $kategori, array $data): bool
    {
        return $kategori->update($data);
    }

    public function hapus(Kategori $kategori): bool
    {
        if ($kategori->inventaris()->count() > 0) {
            throw new \Exception('Kategori tidak dapat dihapus karena masih digunakan oleh data inventaris.');
        }

        return $kategori->delete();
    }
}
