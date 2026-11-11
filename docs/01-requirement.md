# 01 — Requirement

## Tujuan
Aplikasi web **alat bantu petugas** sekolah untuk mencatat peminjaman dan
pengembalian barang, agar petugas tidak menulis data secara manual.

- Ini BUKAN aplikasi untuk peminjam. Peminjam tidak punya akun dan tidak login.
- Data peminjam disimpan sebagai profil supaya pengisian form cepat, riwayatnya
  bisa ditelusuri (tracking), dan datanya bisa dipakai lagi kapan pun diperlukan.

## Ruang lingkup
Termasuk:
- Login petugas dengan dua level: admin dan operator.
- Data induk: petugas, kategori, ruang, inventaris, peminjam.
- Inventaris hanya berisi barang yang akan dipinjamkan (bukan semua barang sekolah).
- Transaksi peminjaman dan pengembalian (dicatat operator).
- Riwayat peminjaman dengan filter, serta export CSV dan Excel (.xlsx).
- Validasi anti-duplikat.

Tidak termasuk (kecuali pengguna meminta):
- Akun atau login peminjam.
- Pengembalian sebagian (pengembalian selalu per transaksi penuh).
- Tanggal jatuh tempo dan filter "terlambat" (perlu tambahan kolom `tanggal_jatuh_tempo`).
- Denda atau biaya.

## Perubahan dari P3 asli (hasil diskusi dengan panitia)
| Aspek | P3 asli | Versi sekarang |
|---|---|---|
| Role | Administrator, operator, peminjam | Admin dan operator saja |
| Peminjam | Tabel pegawai (nama, nip, alamat) | Tabel peminjam: nama, jabatan, aktif (boolean) |
| Admin | Inventaris, peminjaman, pengembalian, laporan | Hanya data induk dan data user |
| Operator | Peminjaman dan pengembalian | Peminjaman dan pengembalian |
| Inventaris | Sarpras sekolah | Hanya barang yang dipinjamkan |
| Kategori | Tabel jenis | Tabel kategori |
| Fitur baru | - | Export CSV/Excel, validasi anti-duplikat |
| AI | - | Boleh dipakai |

## Batasan P3 yang tetap berlaku
- Aplikasi web client-server, berjalan di localhost TANPA internet.
- Bahasa dan database sesuai daftar P3 (dipakai: PHP/Laravel + MySQL).
- Menerapkan OOP dan stored procedure.
- Keluaran: folder proyek, file database .sql (termasuk routines), dokumentasi
  (ERD, deskripsi program, dokumentasi fungsi/prosedur, debugging, pengujian
  dengan screenshot, laporan evaluasi), wireframe, dan user manual.

## Bentuk ujian
Tidak ada live coding. Ujian berupa pertanyaan seputar kode dan kemungkinan
modifikasi bagian tertentu. Karena itu semua kode harus bisa dijelaskan oleh
pengguna, dan setiap milestone dicatat di `docs/penjelasan/`.
