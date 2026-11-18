# Implementasi dan Panduan Penggunaan Aplikasi

## 3.1 Implementasi Basis Data

### 3.1.1 Pembuatan Database
Database aplikasi diinisialisasi dengan nama `peminjaman_sarpras` menggunakan konfigurasi *character set* `utf8mb4` dan *collation* `utf8mb4_unicode_ci` untuk memastikan dukungan penuh terhadap penyimpanan karakter teks dan performa kueri yang optimal pada lingkungan lokal MySQL/MariaDB.

### 3.1.2 Implementasi Tabel dan Relasi
Seluruh tabel utama (`level`, `petugas`, `kategori`, `ruang`, `inventaris`, `peminjam`, `peminjaman`, dan `detail_pinjam`) dibuat melalui skema migrasi Laravel. Aturan integritas relasi antar tabel menggunakan `RESTRICT` pada batasan kunci tamu (*foreign key*) untuk melindungi data master dari penghapusan tidak sengaja saat terikat dengan transaksi aktif.

> *Saran Gambar/Screenshot:* Screenshot struktur tabel di database manager (seperti phpMyAdmin atau TablePlus) dapat dilampirkan pada bagian ini untuk memperkuat bukti implementasi basis data.

### 3.1.3 Koneksi Aplikasi dengan Database
Koneksi antara aplikasi Laravel 13 dan database MySQL dikonfigurasi melalui berkas `.env` dengan parameter utama:
- `DB_CONNECTION=mysql`
- `DB_HOST=127.0.0.1`
- `DB_PORT=3306`
- `DB_DATABASE=peminjaman_sarpras`
- `DB_USERNAME=root`
- `DB_PASSWORD=`
