# 04 — Alur, Halaman, dan Perilaku Frontend

## Alur pencatatan peminjaman (Operator)
1. Barang diserahkan di meja petugas. Operator membuka **Peminjaman Baru**.
2. Operator mencari peminjam (hanya yang `aktif`).
3. Jika belum ada: **tambah cepat** (nama dan jabatan) lewat modal; peminjam baru
   langsung terpilih di form.
4. Tanggal pinjam terisi hari ini (boleh diubah).
5. Operator menambah barang satu per satu (hanya yang stoknya ada) dan jumlahnya.
   Barang yang sama tidak boleh dobel.
6. Simpan: sistem memeriksa stok dan aturan anti-duplikat; transaksi tersimpan
   dengan status `dipinjam`, lalu tampil ringkasan.

## Alur pencatatan pengembalian (Operator)
1. Operator membuka **Pengembalian** (daftar transaksi berstatus `dipinjam`,
   bisa dicari lewat nama peminjam).
2. Buka transaksi, cocokkan barang, tekan **Konfirmasi Kembali**.
3. `tanggal_kembali` terisi hari ini, status menjadi `kembali`, stok otomatis
   tersedia lagi (dihitung dari transaksi).
Pengembalian selalu per transaksi penuh (tidak sebagian).

## Daftar halaman
| Halaman | Admin | Operator |
|---|---|---|
| Login | V | V |
| Dashboard | V | V |
| Data Petugas | V | X |
| Kategori | V | X |
| Ruang | V | X |
| Inventaris | CRUD | lihat saja (daftar dan stok) |
| Peminjam | CRUD dan nonaktifkan | lihat dan tambah |
| Peminjaman Baru | X | V |
| Pengembalian | X | V |
| Riwayat dan Export | V | V |

Dashboard: Admin = jumlah petugas, kategori, barang, peminjam aktif.
Operator = transaksi berjalan, barang tersedia, transaksi hari ini.

Halaman data induk berpola sama: tabel dengan pencarian dan paginasi, tombol
Tambah, Ubah, Hapus (di Peminjam: Nonaktifkan). Aturan hapus: kategori, ruang,
dan barang yang sudah dipakai transaksi tidak bisa dihapus (tampilkan alasannya).
Peminjam tidak dihapus, hanya dinonaktifkan agar riwayat tetap utuh.

## Perilaku otomatis (WAJIB)
Tabel dan filter:
- Pencarian langsung saat mengetik (debounce ~300 ms), tanpa Enter atau tombol.
- Filter kategori, status, dan rentang waktu langsung diterapkan saat berubah.
  Tidak ada tombol "Terapkan"; hanya tombol **Reset**.
- Jumlah data, paginasi, dan urutan kolom berubah tanpa memuat ulang halaman.
- Filter tersimpan di URL; tombol export memakai filter yang sama persis.
- Ada indikator loading, tampilan "tidak ada data", dan toast setelah simpan,
  ubah, atau hapus. Hapus dan nonaktifkan memakai dialog konfirmasi.
Form peminjaman:
- Dropdown peminjam dan barang bisa diketik untuk mencari (Tom Select).
- Jabatan terisi otomatis setelah peminjam dipilih; tanggal pinjam default hari ini.
- Barang yang sudah dipilih hilang dari pilihan baris lain.
- Jumlah dibatasi otomatis sesuai stok tersedia; badge stok berwarna
  (aman, menipis, habis).
Pengembalian: baris hilang setelah dikonfirmasi tanpa memuat ulang halaman.
Data induk: kode barang dibuat otomatis dari `kode_kategori` + nomor urut
(contoh `ELK-001`) dan boleh diubah; `tanggal_register`, petugas pencatat, dan
status terisi otomatis.

## Riwayat dan Export
- Rentang waktu: tombol cepat (Hari ini, 7 hari, 30 hari, Bulan ini, 1 tahun)
  atau tanggal manual (input date), maksimal 1 tahun dengan pesan error jelas.
- Kategori data: Semua, Sedang dipinjam, Sudah dikembalikan. Untuk
  "dikembalikan", rentang dibaca dari `tanggal_kembali`; lainnya dari `tanggal_pinjam`.
- Filter tambahan (opsional): nama peminjam, kategori barang.
- Pratinjau tabel dan jumlah baris tampil dulu, lalu tombol Export CSV dan
  Export Excel (.xlsx) sesuai filter aktif.
- Nama file otomatis, contoh `riwayat-peminjaman_2026-11-01_sd_2026-11-11.xlsx`.
- Isi file: satu baris per barang (tanggal pinjam, peminjam, jabatan, barang,
  jumlah, status, tanggal kembali, petugas).
- CSV memakai UTF-8 dengan BOM agar terbaca benar di Excel.
- Admin juga bisa export data induk (barang, peminjam).

## Wireframe

Kerangka umum (A = hanya Admin, O = hanya Operator):
```
+-----------------+--------------------------------------------------+
| PEMINJAMAN      | [=]  Peminjaman Sarpras         Nama Petugas (Role) v |
| SARPRAS         +--------------------------------------------------+
|                 | Judul Halaman                    Beranda > Halaman |
| Dashboard       |                                                  |
| -- Data Induk --|   (isi halaman)                                  |
| Petugas    (A)  |                                                  |
| Kategori   (A)  |                                                  |
| Ruang      (A)  |                                                  |
| Inventaris (A)  |                                                  |
| Peminjam   (A/O)|                                                  |
| -- Transaksi -- |                                                  |
| Peminjaman (O)  |                                                  |
| Pengembalian(O) |                                                  |
| Riwayat    (A/O)|                                                  |
+-----------------+--------------------------------------------------+
```

Peminjaman Baru:
```
+------------------------------------------------------------------+
| Peminjaman Baru                                                  |
| Peminjam       [ Ketik nama peminjam...                  v ] [+ Baru]
| Jabatan        Guru                      (terisi otomatis)       |
| Tanggal pinjam [ 11-11-2026 ]                                    |
| Barang yang dipinjam                           [+ Tambah barang] |
| +----+--------------------------+--------+--------+              |
| | No | Barang (stok tersedia)   | Jumlah |        |              |
| | 1  | Proyektor (3)          v | [ 1 ]  | [Hapus]|              |
| +----+--------------------------+--------+--------+              |
|                              [Batal]  [Simpan Peminjaman]        |
+------------------------------------------------------------------+
```

Pengembalian:
```
+------------------------------------------------------------------+
| Pengembalian                          Cari: [ nama peminjam...  ]|
| +----+------------------+-------------+---------------+---------+|
| | No | Peminjam         | Tgl pinjam  | Barang        | Aksi    ||
| | 1  | Budi (Guru)      | 10-11-2026  | Proyektor x1..| [Proses]||
| +----+------------------+-------------+---------------+---------+|
+------------------------------------------------------------------+
   [Proses] membuka modal: daftar barang + [Konfirmasi Kembali]
```

Riwayat dan Export:
```
+------------------------------------------------------------------+
| Riwayat Peminjaman                                               |
| Rentang: [Hari ini][7 hari][30 hari][Bulan ini][1 tahun]         |
|          Dari [ 01-11-2026 ]  Sampai [ 11-11-2026 ]  (maks 1 thn)|
| Data:    ( ) Semua  ( ) Sedang dipinjam  ( ) Sudah dikembalikan  |
| Lainnya: Peminjam [ .... ]  Kategori [ Semua v ]        [Reset]  |
| 24 data ditemukan                [Export CSV]  [Export Excel]    |
| +----+------------+----------+-----------+--------+------------+ |
| | No | Peminjam   | Barang   | Tgl pinjam| Status | Tgl kembali| |
| +----+------------+----------+-----------+--------+------------+ |
+------------------------------------------------------------------+
```
