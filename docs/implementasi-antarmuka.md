# Implementasi Antarmuka dan Panduan Penggunaan Aplikasi

## 3.2 Implementasi Antarmuka Aplikasi
Antarmuka sistem dirancang menggunakan kerangka kerja Blade dan komponen AdminLTE 4 yang berjalan secara responsif dan ringan tanpa ketergantungan koneksi internet (offline-first).

> *Saran Gambar/Screenshot:* Setiap poin di bawah sangat direkomendasikan untuk dilengkapi dengan screenshot tampilan asli aplikasi yang telah diisi data uji.

### 3.2.1 Tampilan Halaman Login
Halaman login menjadi pintu utama masuk ke dalam sistem. Menampilkan formulir input *username* dan *password* yang dilengkapi validasi pesan kesalahan jika kredensial salah.

### 3.2.2 Tampilan Halaman Dashboard
Halaman dashboard menampilkan ringkasan informasi dan pintasan navigasi sesuai dengan hak akses pengguna yang sedang aktif (Admin/Operator).

### 3.2.3 Tampilan Halaman Inventaris
Halaman inventaris menampilkan daftar barang sarpras yang siap dipinjamkan, dilengkapi kolom pencarian dan filter otomatis tanpa tombol terapkan.

### 3.2.4 Tampilan Halaman Peminjaman
Halaman peminjaman menampilkan formulir pencatatan transaksi peminjaman baru serta daftar transaksi aktif yang sedang dipinjam.

### 3.2.5 Tampilan Halaman Pengembalian
Halaman pengembalian memuat data transaksi peminjaman aktif beserta tombol eksekusi pengembalian barang secara penuh.

### 3.2.6 Tampilan Halaman Laporan
Halaman laporan menyajikan rekapitulasi histori peminjaman dengan fitur filter serta tombol eksport data ke format CSV dan Excel (.xlsx).

---

## 3.3 Panduan Penggunaan Aplikasi

### 3.3.1 Penggunaan Login (Sesuai Hak Akses)
1. Akses aplikasi melalui browser di alamat local dev (misal: `http://localhost/peminjaman-sarpras` atau `http://127.0.0.1:8000`).
2. Masukkan *username* dan *password* akun petugas yang terdaftar (Admin/Operator).
3. Klik tombol **Login**.

### 3.3.2 Fungsi Dashboard (Sesuai Hak Akses)
- **Admin:** Memantau ringkasan data master (total petugas, inventaris, kategori, peminjam) dan navigasi ke menu kelola data master.
- **Operator:** Memantau statistik peminjaman aktif dan navigasi cepat ke formulir peminjaman/pengembalian barang.

### 3.3.3 Penggunaan Halaman Inventaris (Sesuai Hak Akses)
1. Pilih menu **Inventaris** pada bilah samping.
2. Gunakan kolom pencarian untuk menemukan barang berdasarkan nama atau kode inventaris.
3. Admin dapat menambah, mengubah, atau menonaktifkan data barang inventaris.

### 3.3.4 Penggunaan Halaman Peminjaman (Sesuai Hak Akses)
1. Pilih menu **Peminjaman**.
2. Klik tombol **Tambah Peminjaman**.
3. Pilih nama peminjam dari daftar profil yang ada (atau buat profil baru).
4. Pilih item barang inventaris dan masukkan jumlah barang yang dipinjam.
5. Klik **Simpan Transaksi**.

### 3.3.5 Penggunaan Halaman Pengembalian (Sesuai Hak Akses)
1. Pilih menu **Pengembalian**.
2. Cari transaksi peminjaman aktif yang akan dikembalikan.
3. Klik tombol **Proses Pengembalian**.
4. Konfirmasi dialog pengembalian. Stok barang otomatis bertambah kembali.

### 3.3.6 Penggunaan Halaman Laporan (Sesuai Hak Akses)
1. Pilih menu **Laporan**.
2. Tentukan filter rentang tanggal atau status transaksi jika diperlukan.
3. Klik tombol **Export CSV** atau **Export Excel** untuk mengunduh rekapitulasi data.
