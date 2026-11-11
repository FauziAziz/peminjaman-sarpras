# 05 — Keputusan Teknis (sudah disetujui pengguna)

| Aspek | Keputusan |
|---|---|
| Framework | Laravel 13 + MySQL, tanpa starter kit |
| Template | AdminLTE 4 (Bootstrap 5.3, tanpa jQuery), aset lokal di `public/vendor/`, layout Blade dibuat sendiri (tanpa paket integrasi) |
| Aset lokal | adminlte, bootstrap, bootstrap-icons (+ folder fonts), overlayscrollbars, tom-select. Font memakai font sistem |
| Offline | Dilarang CDN dan Google Fonts |
| Penamaan | Tabel dan kolom mengikuti PDM P3; model memakai `$table` dan `$primaryKey` eksplisit |
| Login | Tabel `petugas`, memakai `username` (bukan email) |
| Akses | Middleware level (`admin` atau `operator`) pada grup route |
| Pencarian dan filter | Diproses di server (query), hasil dimuat lewat `fetch` (JS murni); satu modul JS dan satu komponen Blade dipakai semua tabel |
| Dropdown cari | Tom Select (lokal) |
| Tanggal | `<input type="date">` bawaan browser (tanpa Flatpickr) |
| Export | `maatwebsite/excel` versi `^4.0` (versi 3.1 tidak mendukung PHP 8.5) untuk CSV dan xlsx |
| Session dan cache | Driver `file` (tidak membuat tabel tambahan) |
| Zona waktu | `Asia/Jakarta` di `config/app.php`; `APP_LOCALE=id` |
| Git | Branch `main`; satu branch per milestone (`milestone/NN-nama`); commit dilakukan pengguna |

## Lapisan kode (OOP)
Controller tipis -> FormRequest (validasi) -> Service (aturan bisnis) -> Model.
Stored procedure dipanggil dari Service. Anti-duplikat dua lapis: validasi
Laravel + unique index database.

## Lingkungan
Laragon, PHP 8.5.12, Composer 2.10.3, Laravel 13.42.0, Node 22, MySQL.
Proyek: `C:\laragon\www\peminjaman-sarpras`, URL `http://peminjaman-sarpras.test`.
Proyek lama `inventaris-skull` TIDAK boleh diubah (hanya acuan).

## Tidak dipakai (sengaja)
Laravel Boost, Livewire, Breeze/Jetstream, jQuery, Flatpickr, DataTables/Tabulator,
Vite pipeline untuk aset template, CDN apa pun.
