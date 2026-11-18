<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Level
        DB::table('level')->insertOrIgnore([
            ['id_level' => 1, 'nama_level' => 'admin'],
            ['id_level' => 2, 'nama_level' => 'operator'],
        ]);

        // 2. Petugas
        DB::table('petugas')->insertOrIgnore([
            [
                'id_petugas' => 1,
                'username' => 'admin',
                'password' => Hash::make('password'),
                'nama_petugas' => 'Administrator Utama',
                'id_level' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_petugas' => 2,
                'username' => 'operator',
                'password' => Hash::make('password'),
                'nama_petugas' => 'Petugas Sarpras',
                'id_level' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 3. Kategori
        DB::table('kategori')->insertOrIgnore([
            ['id_kategori' => 1, 'nama_kategori' => 'Elektronik', 'kode_kategori' => 'ELK', 'keterangan' => 'Peralatan elektronik'],
            ['id_kategori' => 2, 'nama_kategori' => 'Olahraga', 'kode_kategori' => 'OLG', 'keterangan' => 'Peralatan olahraga sekolah'],
        ]);

        // 4. Ruang
        DB::table('ruang')->insertOrIgnore([
            ['id_ruang' => 1, 'nama_ruang' => 'Gudang Utama', 'kode_ruang' => 'GDG-01', 'keterangan' => 'Lantai 1'],
            ['id_ruang' => 2, 'nama_ruang' => 'Lab Komputer', 'kode_ruang' => 'LAB-01', 'keterangan' => 'Lantai 2'],
        ]);

        // 5. Inventaris
        DB::table('inventaris')->insertOrIgnore([
            [
                'id_inventaris' => 1,
                'kode_inventaris' => 'ELK-001',
                'nama' => 'Proyektor Epson EB-X400',
                'id_kategori' => 1,
                'id_ruang' => 1,
                'jumlah' => 5,
                'kondisi' => 'baik',
                'keterangan' => 'Termasuk kabel HDMI',
                'tanggal_register' => '2026-01-10',
                'id_petugas' => 1,
            ],
            [
                'id_inventaris' => 2,
                'kode_inventaris' => 'OLG-001',
                'nama' => 'Bola Basket Molten',
                'id_kategori' => 2,
                'id_ruang' => 1,
                'jumlah' => 10,
                'kondisi' => 'baik',
                'keterangan' => 'Ukuran 7',
                'tanggal_register' => '2026-02-01',
                'id_petugas' => 1,
            ],
        ]);

        // 6. Peminjam
        DB::table('peminjam')->insertOrIgnore([
            ['id_peminjam' => 1, 'nama_peminjam' => 'Budi Santoso', 'jabatan' => 'Guru', 'aktif' => 1],
            ['id_peminjam' => 2, 'nama_peminjam' => 'Siti Rahma', 'jabatan' => 'Siswa (Ketua OSIS)', 'aktif' => 1],
        ]);
    }
}
