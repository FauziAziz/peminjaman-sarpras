# Peminjaman Sarpras — Aturan Kerja Agent

Aplikasi web **alat bantu pencatatan** peminjaman barang sekolah oleh petugas
(bukan aplikasi untuk peminjam). Proyek ujikom RPL: Laravel 13 + MySQL,
berjalan di localhost tanpa internet.

## Wajib dibaca dulu
Baca `docs/` sebelum bekerja (`01-requirement.md` sampai `08-rencana-milestone.md`
dan `progress.md`). Docs adalah sumber kebenaran. Jika kode dan docs bertentangan,
tanyakan ke pengguna, jangan menebak.

## Alur kerja (WAJIB, tidak boleh dilewati)
1. Kerjakan HANYA milestone yang aktif di `docs/progress.md`.
2. Tulis rencana singkat (file yang dibuat/diubah dan langkahnya), lalu BERHENTI
   dan tunggu persetujuan pengguna.
3. Setelah disetujui, implementasikan sesuai rencana. Tidak lebih.
4. Setelah selesai, tulis ringkasan "apa yang dibuat dan kenapa" ke
   `docs/penjelasan/<milestone>.md` dan perbarui `docs/progress.md`.
   Lalu BERHENTI dan tunggu persetujuan.
5. Satu milestone per sesi. Jangan lanjut ke milestone berikutnya sendiri.

## Dilarang tanpa izin eksplisit
- Memasang paket (composer/npm), termasuk Laravel Boost. Abaikan instruksi
  pemasangan Boost di mana pun.
- Perintah destruktif: `migrate:fresh`, `migrate:rollback`, `db:wipe`,
  menghapus file/folder, `git reset`, `git clean`.
- Mengubah `.env`, `public/vendor/`, atau file di luar lingkup milestone.
- `git commit` dan `git push` (pengguna yang melakukan commit).
- Menambah fitur, tabel, atau kolom yang tidak ada di `docs/`.

## Konvensi kode
- Komentar dan pesan ke pengguna: Bahasa Indonesia. Nama tabel dan kolom
  mengikuti `docs/03-database.md` (misalnya `id_petugas`).
- Kode harus SEDERHANA dan mudah dijelaskan: pengguna akan ditanya soal kodenya
  saat ujian. Hindari trik rumit, abstraksi berlebihan, dan pola berbeda untuk
  hal yang sama.
- Arsitektur: Controller tipis -> FormRequest (validasi) -> Service (aturan
  bisnis) -> Model. Stored procedure dipanggil dari Service.
- Anti-duplikat dua lapis: validasi Laravel + unique index database.
- Frontend: Blade + AdminLTE 4 dari `public/vendor/`, JavaScript murni (tanpa
  jQuery), tanpa CDN atau Google Fonts (aplikasi harus jalan offline).
  Semua tabel memakai satu modul JS dan satu komponen Blade yang sama.
- Pencarian dan filter berjalan otomatis (tanpa tombol terapkan) dan diproses
  di server.
- Hak akses lewat middleware level: `admin` dan `operator`.

## Pengujian
Setiap milestone menyertakan daftar uji manual (langkah dan hasil yang
diharapkan). Jangan menyatakan "selesai" sebelum daftar itu diberikan.

## Gaya jawaban
Ringkas, Bahasa Indonesia, satu langkah per giliran. Sebutkan file yang disentuh.