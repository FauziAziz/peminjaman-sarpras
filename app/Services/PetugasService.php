<?php

namespace App\Services;

use App\Models\Petugas;
use Illuminate\Support\Facades\Hash;

class PetugasService
{
    public function simpan(array $data): Petugas
    {
        $data['password'] = Hash::make($data['password']);
        return Petugas::create($data);
    }

    public function perbarui(Petugas $petugas, array $data): bool
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        return $petugas->update($data);
    }

    public function hapus(Petugas $petugas): bool
    {
        return $petugas->delete();
    }
}
