# Dokumentasi Final & Panduan Ujian — Peminjaman Sarpras

Aplikasi **Peminjaman Sarpras** adalah alat bantu petugas sekolah untuk mencatat peminjaman dan pengembalian barang secara digital, dibangun menggunakan Laravel 13 dan MySQL dengan menerapkan arsitektur *Stored Procedure* dan *Service Layer*.

---

## 1. Struktur & Relasi Database (ERD Ringkas)
Relasi antar tabel dalam database `peminjaman_sarpras`:
- `level` (1) ──< `petugas` (N)
- `petugas` (1) ──< `inventaris` (N) & `petugas` (1) ──< `peminjaman` (N)
- `kategori` (1) ──< `inventaris` (N)
- `ruang` (1) ──< `inventaris` (N)
- `peminjam` (1) ──< `peminjaman` (N)
- `peminjaman` (1) ──< `detail_pinjam` (N)
- `inventaris` (1) ──< `detail_pinjam` (N)

*Catatan:* Semua Foreign Key menggunakan aturan `RESTRICT` sehingga data master yang sudah berelasi dengan transaksi tidak dapat dihapus secara langsung.

---

## 2. Deskripsi Program & Arsitektur
Arsitektur kode dirancang sederhana dan modular:
1. **Controller (Tipis):** Menerima HTTP Request, memanggil FormRequest untuk validasi, dan menyerahkan logika bisnis ke Service.
2. **FormRequest:** Menangani validasi input user dan aturan anti-duplikat dengan pesan error berbahasa Indonesia.
3. **Service Layer:** Membungkus aturan bisnis dan pemanggilan Stored Procedure di dalam `DB::transaction()`.
4. **Stored Procedure & Fungsi MySQL:**
   - `fn_stok_tersedia(id)`: Menghitung stok tersisa berdasarkan jumlah total dikurangi kuantitas pada transaksi aktif (`dipinjam`).
   - `sp_buat_peminjaman`: Membuat header transaksi peminjaman.
   - `sp_tambah_detail_pinjam`: Memvalidasi stok & anti-duplikat barang, lalu memasukkan detail pinjam.
   - `sp_kembalikan_peminjaman`: Mengubah status peminjaman menjadi `kembali` dan memulihkan stok.
   - `sp_riwayat_peminjaman`: Mengambil data riwayat berdasarkan rentang tanggal (maks 1 tahun) dan filter.

---

## 3. Akun Akses (Login)
Sesuai data seeder awal:
- **Admin:** Username: `admin` | Password: `password`
- **Operator:** Username: `operator` | Password: `password`

---

## 4. Panduan User Manual (Penggunaan Singkat)
1. **Login:** Buka aplikasi, masukkan username dan password sesuai level hak akses.
2. **Admin:** Mengelola data induk (Petugas, Kategori, Ruang, Inventaris, Peminjam) melalui menu sidebar.
3. **Operator:**
   - **Peminjam:** Melihat dan menambah profil peminjam.
   - **Peminjaman Baru:** Memilih peminjam, tanggal, dan menambahkan daftar barang beserta jumlahnya.
   - **Pengembalian:** Melihat daftar barang yang sedang dipinjam dan menekan tombol konfirmasi kembali.
4. **Riwayat & Export:** Memilih rentang tanggal, filter status/kategori, melihat pratinjau tabel, serta mengunduh laporan dalam format CSV atau Excel (`.xlsx`).

---

## 5. Panduan Debugging & Troubleshooting
- **Error Stok Tidak Cukup / Validasi Prosedur:** Ditangani oleh `SIGNAL SQLSTATE '45000'` di database dan ditangkap oleh Service/Controller untuk ditampilkan sebagai pesan error yang mudah dipahami.
- **Asset / Tampilan Rusak (Offline):** Pastikan folder `public/vendor/` lengkap (Bootstrap, AdminLTE 4, Tom Select) karena aplikasi dirancang berjalan tanpa koneksi internet (tanpa CDN).
- **Kesalahan Rentang Riwayat:** Stored procedure menolak rentang tanggal lebih dari 365 hari atau tanggal terbalik. Pastikan rentang waktu valid.
