# 03 — Database

Nama database: `peminjaman_sarpras` (utf8mb4, utf8mb4_unicode_ci).
Nama tabel dan kolom mengikuti PDM P3 (bahasa Indonesia, PK `id_<tabel>`).
Model Laravel mengatur `$table` dan `$primaryKey` secara eksplisit.

> Tipe data di bawah adalah USULAN, dikonfirmasi saat milestone migration.

## Tabel
| Tabel | Kolom | Catatan |
|---|---|---|
| `level` | id_level PK, nama_level (unik) | Isi: admin, operator |
| `petugas` | id_petugas PK, username (unik), password (hash), nama_petugas, id_level FK | Tabel login |
| `kategori` | id_kategori PK, nama_kategori (unik), kode_kategori (unik), keterangan (null) | Menggantikan `jenis` |
| `ruang` | id_ruang PK, nama_ruang (unik), kode_ruang (unik), keterangan (null) | Lokasi simpan barang |
| `inventaris` | id_inventaris PK, kode_inventaris (unik), nama, id_kategori FK, id_ruang FK (null), jumlah, kondisi, keterangan (null), tanggal_register, id_petugas FK | Hanya barang yang dipinjamkan |
| `peminjam` | id_peminjam PK, nama_peminjam, jabatan, aktif (boolean, default true) | Menggantikan `pegawai` |
| `peminjaman` | id_peminjaman PK, id_peminjam FK, id_petugas FK, tanggal_pinjam, tanggal_kembali (null), status_peminjaman | `id_petugas` = operator pencatat |
| `detail_pinjam` | id_detail_pinjam PK, id_peminjaman FK, id_inventaris FK, jumlah | Satu transaksi, banyak barang |

Nilai `status_peminjaman`: `dipinjam` atau `kembali`.
Nilai `kondisi` (usulan): `baik`, `rusak ringan`, `rusak berat`.

## Relasi
- kategori 1:N inventaris; ruang 1:N inventaris
- level 1:N petugas
- petugas 1:N inventaris; petugas 1:N peminjaman
- peminjam 1:N peminjaman
- peminjaman 1:N detail_pinjam; inventaris 1:N detail_pinjam

Semua FK memakai RESTRICT: data yang sudah dipakai tidak bisa dihapus.

## Aturan unik (anti-duplikat, dua lapis: validasi Laravel + unique index DB)
| Data | Unik |
|---|---|
| petugas | username |
| kategori | nama_kategori; kode_kategori |
| ruang | nama_ruang; kode_ruang |
| inventaris | kode_inventaris; gabungan (nama, id_kategori) |
| peminjam | gabungan (nama_peminjam, jabatan) |
| detail_pinjam | gabungan (id_peminjaman, id_inventaris) |

Catatan: dua orang berbeda dengan nama dan jabatan yang sama akan ditolak;
operator perlu membedakan nama (misalnya menambah inisial).

## Stok
Stok tersedia TIDAK disimpan di kolom. Dihitung:
`jumlah` dikurangi total `detail_pinjam.jumlah` dari transaksi berstatus `dipinjam`.
Dihitung lewat fungsi `fn_stok_tersedia` dan view `v_stok_inventaris`
(lihat `06-stored-procedure.md`).

## Data awal (seeder, usulan)
- Level: admin, operator.
- Satu akun admin dan satu akun operator untuk pengembangan. Password ditentukan
  saat milestone seeder; JANGAN ditulis di docs atau dikomit sebagai password asli.
- Contoh kategori, ruang, barang, dan peminjam untuk demo.
