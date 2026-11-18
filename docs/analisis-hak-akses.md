# Analisis Hak Akses

Sistem aplikasi pencatatan peminjaman sarpras ini membatasi hak akses pengguna menggunakan middleware level (`admin` dan `operator`) untuk menjaga keamanan dan kejelasan tugas operasional.

## 2.3.1 Administrator
Administrator memiliki hak akses tertinggi dalam pengelolaan data master dan konfigurasi sistem. Tugas utama administrator meliputi:
- Mengelola data master petugas dan hak akses level.
- Mengelola data master kategori barang dan ruang penyimpanan.
- Mengelola data master barang inventaris sekolah yang khusus dipinjamkan.
- Mengelola data master pemilih/peminjam (nama dan jabatan).
- Mengakses rekapitulasi laporan riwayat peminjaman secara menyeluruh.

## 2.3.2 Operator
Operator bertugas menjalankan operasional harian transaksi peminjaman dan pengembalian sarpras. Tugas utama operator meliputi:
- Mencatat transaksi peminjaman barang baru oleh peminjam.
- Mencatat proses pengembalian barang sarpras yang telah selesai dipinjam.
- Melihat daftar inventaris dan ketersediaan stok barang.
- Melihat, memfilter, serta mengunduh laporan riwayat peminjaman dalam bentuk CSV atau Excel.

## 2.3.3 Peminjam
Sesuai dengan ruang lingkup proyek uji kompetensi ini, **peminjam tidak memiliki akun login (tidak ada halaman akses untuk peminjam)**. Data peminjam (seperti nama dan jabatan) diinput dan dikelola langsung oleh petugas (admin/operator) saat transaksi peminjaman dicatat, guna mempercepat proses input dan memastikan histori penelusuran (tracking) tercatat dengan akurat.
