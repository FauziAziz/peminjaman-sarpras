# 06 — Stored Procedure, Fungsi, dan View

> Nama objek disetujui di Tahap 2. RINCIAN parameter, aturan validasi, dan pesan
> error di bawah adalah USULAN yang diperiksa pengguna sebelum milestone database.

## Cara pembuatan dan pemakaian
- Dibuat lewat migration memakai `DB::unprepared()` (satu statement
  `CREATE PROCEDURE ... BEGIN ... END`, tanpa `DELIMITER`). Setiap migration
  punya `down()` yang memakai `DROP ... IF EXISTS`.
- Dipanggil dari Service (bukan dari Controller). Transaksi database dibungkus
  `DB::transaction()` di Service.
- Aturan yang dilanggar menghasilkan `SIGNAL SQLSTATE '45000'` dengan
  `MESSAGE_TEXT` berbahasa Indonesia. Service menangkap `QueryException` dan
  menampilkan pesannya ke pengguna.
- File `.sql` untuk dikumpulkan dibuat dengan
  `mysqldump -u root --routines peminjaman_sarpras > database/sql/peminjaman_sarpras.sql`.

## Fungsi dan view
| Objek | Fungsi |
|---|---|
| `fn_stok_tersedia(p_id_inventaris)` | Mengembalikan `jumlah` dikurangi total `detail_pinjam.jumlah` dari transaksi berstatus `dipinjam` |
| view `v_stok_inventaris` | Kolom: id_inventaris, kode_inventaris, nama, id_kategori, id_ruang, jumlah, dipinjam, tersedia |

## Stored procedure
### sp_buat_peminjaman(p_id_peminjam, p_id_petugas, p_tanggal_pinjam)
- Menolak jika peminjam tidak ada atau `aktif = 0`.
- Menyimpan `peminjaman` dengan status `dipinjam`.
- Mengembalikan `SELECT LAST_INSERT_ID() AS id_peminjaman`.

### sp_tambah_detail_pinjam(p_id_peminjaman, p_id_inventaris, p_jumlah)
- Menolak jika transaksi tidak ada atau status bukan `dipinjam`.
- Menolak jika `p_jumlah` kurang dari 1.
- Menolak jika barang yang sama sudah ada di transaksi itu.
- Mengunci baris inventaris (`FOR UPDATE`), menolak jika stok tersedia kurang
  dari `p_jumlah`.
- Menyimpan `detail_pinjam`.

### sp_kembalikan_peminjaman(p_id_peminjaman, p_tanggal_kembali)
- Menolak jika transaksi tidak ada atau status bukan `dipinjam`.
- Menolak jika `p_tanggal_kembali` lebih awal dari `tanggal_pinjam`.
- Mengisi `tanggal_kembali` dan mengubah status menjadi `kembali`.

### sp_riwayat_peminjaman(p_dari, p_sampai, p_status, p_peminjam, p_id_kategori)
- Satu-satunya sumber data riwayat: dipakai halaman Riwayat DAN export.
- `p_status`: NULL atau `semua`, `dipinjam`, `kembali`.
- Tanggal yang difilter: `tanggal_kembali` jika `p_status = 'kembali'`,
  selain itu `tanggal_pinjam`.
- `p_peminjam` dan `p_id_kategori` opsional (NULL = tidak difilter);
  `p_peminjam` memakai LIKE.
- Menolak jika `p_sampai` lebih awal dari `p_dari` atau rentang lebih dari 1 tahun.
- Mengembalikan satu baris per barang: tanggal pinjam, peminjam, jabatan,
  barang, jumlah, status, tanggal kembali, petugas.
- Paginasi tampilan dilakukan di Laravel (volume data sekolah kecil), sehingga
  export dan tampilan memakai hasil yang sama persis.

## Pesan error (usulan)
| Situasi | Pesan |
|---|---|
| Peminjam tidak aktif atau tidak ada | Peminjam tidak ditemukan atau sudah tidak aktif. |
| Transaksi tidak valid | Transaksi tidak ditemukan atau sudah dikembalikan. |
| Jumlah kurang dari 1 | Jumlah barang minimal 1. |
| Barang dobel | Barang ini sudah ada di transaksi. |
| Stok kurang | Stok barang tidak mencukupi. |
| Tanggal kembali sebelum pinjam | Tanggal kembali tidak boleh sebelum tanggal pinjam. |
| Rentang riwayat salah | Rentang tanggal tidak valid (maksimal 1 tahun). |
