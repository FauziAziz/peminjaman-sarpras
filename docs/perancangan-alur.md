# Perancangan Alur Sistem

## 2.4.1 Flowchart Sistem
Flowchart atau bagan alur sistem menggambarkan tahapan prosedur operasional yang berjalan di dalam aplikasi pencatatan peminjaman sarpras.

1. **Alur Autentikasi (Login):**
   - Petugas mengakses halaman utama aplikasi.
   - Menginputkan *username* dan *password*.
   - Sistem memvalidasi kredensial ke database. Jika valid, sistem mengarahkan ke halaman *Dashboard* sesuai hak akses (*admin* atau *operator*). Jika tidak valid, sistem menampilkan pesan kesalahan.

2. **Alur Transaksi Peminjaman:**
   - Operator memilih menu transaksi peminjaman.
   - Memilih data peminjam (atau menambah data baru jika belum ada).
   - Memilih barang inventaris beserta jumlah yang akan dipinjam.
   - Sistem memvalidasi ketersediaan stok barang. Jika mencukupi, transaksi disimpan dan status barang tercatat aktif dipinjam.

3. **Alur Transaksi Pengembalian:**
   - Operator membuka daftar transaksi peminjaman yang berstatus aktif.
   - Memilih transaksi yang akan dikembalikan.
   - Mengonfirmasi pengembalian, sehingga status peminjaman berubah menjadi kembali dan stok barang diperbarui secara otomatis.

## 2.4.2 Use Case Diagram
Use Case Diagram merepresentasikan fungsionalitas sistem dari sudut pandang aktor yang terlibat di dalamnya. Hubungan antara aktor dan proses utama dapat diringkas sebagai berikut:
- **Admin:** Berinteraksi dengan modul *Login*, *Dashboard*, *Manajemen Data Master* (Petugas, Kategori, Ruang, Inventaris, Peminjam), serta *Manajemen Laporan*.
- **Operator:** Berinteraksi dengan modul *Login*, *Dashboard*, *Manajemen Transaksi* (Peminjaman & Pengembalian), serta *Manajemen Laporan*.
- File diagram terpisah dapat dilihat pada `docs/diagram-laporan.md`.
