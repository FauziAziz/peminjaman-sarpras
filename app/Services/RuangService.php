<?php

namespace App\Services;

use App\Models\Ruang;

class RuangService
{
    public function simpan(array $data): Ruang
    {
        return Ruang::create($data);
    }

    public function perbarui(Ruang $ruang, array $data): bool
    {
        return $ruang->update($data);
    }

    public function hapus(Ruang $ruang): bool
    {
        if ($ruang->inventaris()->count() > 0) {
            throw new \Exception('Ruang tidak dapat dihapus karena masih digunakan oleh data inventaris.');
        }

        return $ruang->delete();
    }
}
