# 07 — Konvensi Kode

Melengkapi `AGENTS.md`. Prinsip utama: kode SEDERHANA, konsisten, dan bisa
dijelaskan pengguna saat ujian.

## Penamaan
- Model (tunggal, PascalCase): `Level`, `Petugas`, `Kategori`, `Ruang`,
  `Inventaris`, `Peminjam`, `Peminjaman`, `DetailPinjam`. Wajib set `$table`,
  `$primaryKey`; `$timestamps` sesuai migration.
- Controller: `<Nama>Controller` (resource controller bila cocok).
- FormRequest: `<Nama>Request` (aturan validasi + pesan Indonesia).
- Service: `PeminjamanService` (buat peminjaman, kembalikan), `RiwayatService`
  (memanggil `sp_riwayat_peminjaman`). Export: `app/Exports/RiwayatExport.php`.
- Route: nama berbahasa Indonesia, contoh `kategori.index`, `peminjaman.create`,
  `pengembalian.index`, `riwayat.index`, `riwayat.export`.
- View: `resources/views/<fitur>/index|create|edit.blade.php`; layout di
  `resources/views/layouts/`; komponen di `resources/views/components/`.

## Pola yang diulang (jangan buat pola baru)
- Semua halaman daftar memakai komponen Blade `<x-tabel-otomatis>` dan satu file
  `public/js/tabel-otomatis.js`.
- Server mengembalikan potongan HTML tabel; JS mengganti isi tabel lewat `fetch`.
- Filter dan pencarian disimpan di query string URL.
- Semua dropdown cari memakai Tom Select dengan satu fungsi inisialisasi bersama.

## Frontend
- JavaScript murni (tanpa jQuery, tanpa framework). Fungsi pendek, dikomentari.
- Aset hanya dari `public/vendor/`; tidak ada CDN.
- Format tanggal tampil `d-m-Y`, disimpan `Y-m-d`.
- Notifikasi memakai toast Bootstrap; konfirmasi hapus memakai modal Bootstrap.

## Backend
- Validasi lewat FormRequest; pesan error Bahasa Indonesia
  (file terjemahan `lang/id/validation.php` dibuat di milestone awal).
- Aturan bisnis hanya di Service dan stored procedure, bukan di Controller atau view.
- Hindari: repository pattern, event/observer, trait kustom, paket tambahan.
- Komentar Bahasa Indonesia yang menjelaskan KENAPA, bukan hanya APA.

## Pengujian per milestone
Setiap milestone menyertakan daftar uji manual:
| No | Langkah | Hasil yang diharapkan |
|---|---|---|
Lengkapi minimal: kasus berhasil, kasus gagal (validasi), dan kasus hak akses.

## Git
Branch `milestone/NN-nama`. Pengguna yang melakukan commit dan merge ke `main`
setelah memahami dan menyetujui hasilnya.
