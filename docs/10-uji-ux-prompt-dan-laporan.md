# Uji UI/UX: Prompt dan Template Laporan

Standar acuan: 10 Usability Heuristics (Nielsen), WCAG 2.2 level AA, dan System Usability Scale (SUS) untuk uji pengguna.

Catatan batasan: analisis AI hanya bisa menilai apa yang terlihat di screenshot dan terbaca di kode. Hasilnya menjadi daftar dugaan masalah, bukan bukti bahwa pengguna nyata kesulitan. Karena itu ada Bagian 4 (uji pengguna singkat).

---

## 1. Urutan pengujian

1. **Alat otomatis (10 menit)**: Lighthouse di Chrome DevTools (kategori Accessibility dan Best Practices) pada tiap halaman utama; ekstensi axe DevTools atau WAVE. Catat skor dan temuan.
2. **Uji keyboard manual (10 menit)**: Tab melewati seluruh halaman. Fokus harus terlihat, urutan masuk akal, form bisa dikirim dengan Enter, modal bisa ditutup dengan Esc.
3. **Analisis AI (prompt di Bagian 2)**: kirim screenshot + isi file Blade halaman terkait.
4. **Uji pengguna singkat (Bagian 4)**: 3-5 orang menjalankan tugas nyata.
5. **Laporan dan tindak lanjut (Bagian 3 dan 5)**.

Halaman yang diuji (minimal): login, dashboard, daftar inventaris (cari/filter), form peminjaman, form pengembalian, riwayat + export, kelola user (admin).

---

## 2. Prompt analisis (salin ke agent atau chat)

Lampirkan: screenshot halaman (desktop, dan HP bila ada), file Blade halaman tersebut, dan nama peran yang memakai halaman itu.

```
Peran: kamu reviewer UI/UX. Kamu HANYA menganalisis dan melapor. Jangan mengubah kode atau file apa pun.

Konteks aplikasi: alat bantu petugas sekolah (operator dan admin) untuk mencatat peminjaman dan pengembalian barang. Peminjam tidak login. Pengguna utama adalah operator yang bekerja cepat, sering mengulang tugas yang sama. Template: AdminLTE 4 (jangan menyarankan mengganti template).

Halaman yang dinilai: [nama halaman]. Peran: [admin/operator].

Nilai berdasarkan tiga standar:
1. Nielsen's 10 usability heuristics (visibilitas status sistem, kesesuaian dengan dunia nyata, kontrol pengguna, konsistensi, pencegahan error, pengenalan bukan pengingatan, fleksibilitas dan efisiensi, desain minimalis, bantuan pemulihan error, bantuan dan dokumentasi).
2. WCAG 2.2 level AA: kontras warna (teks 4.5:1, teks besar 3:1), label form, urutan dan fokus keyboard, ukuran target sentuh, teks alternatif, pesan error yang terhubung ke kolomnya, tidak mengandalkan warna saja.
3. Kelayakan tugas: berapa klik/langkah untuk menyelesaikan tugas utama halaman ini, dan apa yang bisa dipersingkat.

Aturan:
- Hanya laporkan temuan yang bisa dibuktikan dari screenshot atau kode yang saya lampirkan. Sebutkan buktinya (bagian layar atau baris kode). Jika tidak yakin, tulis "perlu dicek manual", jangan menebak.
- Jangan mengarang angka kontras; jika tidak bisa dihitung dari yang terlihat, minta nilai warna atau tandai perlu dicek dengan alat.
- Jangan memuji berlebihan. Sebutkan juga hal yang sudah baik, maksimal 3, singkat.
- Jangan menyarankan fitur di luar soal; fokus pada perbaikan kecil yang realistis dalam waktu singkat.

Format keluaran: tabel temuan dengan kolom
ID | Halaman | Masalah | Bukti | Standar (heuristik/WCAG no.) | Keparahan (0-4) | Rekomendasi spesifik | Perkiraan usaha (kecil/sedang/besar)

Skala keparahan: 0 = bukan masalah, 1 = kosmetik, 2 = ringan, 3 = penting, 4 = menghalangi tugas.

Setelah tabel: (a) ringkasan 5 baris, (b) urutan perbaikan yang disarankan (keparahan tinggi dan usaha kecil dulu), (c) daftar hal yang perlu dicek manual atau diuji dengan pengguna.
Minta persetujuan saya sebelum menulis apa pun ke berkas docs/laporan-ux.md.
```

---

## 3. Template laporan (docs/laporan-ux.md)

```
# Laporan Uji UI/UX
Tanggal: ____  Penguji: ____  Versi/commit: ____

## Ringkasan
- Halaman diuji: ____
- Skor Lighthouse Accessibility (rata-rata): ____
- Jumlah temuan: keparahan 4: _  3: _  2: _  1: _
- Skor SUS (jika ada uji pengguna): ____

## Temuan
| ID | Halaman | Masalah | Bukti | Standar | Keparahan | Rekomendasi | Usaha | Status | Commit |
|----|---------|---------|-------|---------|-----------|-------------|-------|--------|--------|
| U-01 | | | screenshot/baris | H5 / WCAG 3.3.1 | 3 | | kecil | belum | |

Status: belum / dikerjakan / selesai / ditolak (tulis alasan) / perlu uji ulang

## Yang sudah baik
- ...

## Hasil uji pengguna
(lihat Bagian 4)

## Keputusan
Temuan yang sengaja tidak diperbaiki beserta alasannya.
```

---

## 4. Uji pengguna singkat (3-5 orang)

Pilih orang yang mirip pengguna nyata (guru, teman yang paham sekolah). Jangan beri petunjuk, cukup amati dan catat.

Tugas contoh (peran operator):
1. Masuk ke aplikasi.
2. Catat peminjaman 2 barang atas nama seorang peminjam.
3. Cari peminjam yang belum terdaftar lalu tambahkan, kemudian catat peminjamannya.
4. Catat pengembalian barang tersebut.
5. Ekspor riwayat satu bulan terakhir untuk barang yang masih dipinjam ke Excel.

Catat per tugas: berhasil/tidak, waktu, jumlah salah klik, kalimat yang diucapkan pengguna.

SUS: setelah semua tugas, minta tiap orang menilai 10 pernyataan standar SUS (skala 1-5). Skor 0-100; rata-rata umum sekitar 68. Dengan hanya 3-5 orang, anggap angka ini indikasi kasar, bukan bukti statistik. Isi temuan kualitatif lebih berguna.

---

## 5. Alur tindak lanjut

1. Urutkan: keparahan 4 lalu 3, dengan usaha kecil lebih dulu.
2. Kerjakan per kelompok kecil, satu commit per perbaikan, tulis ID temuan di pesan commit (contoh: `fix: pesan error form peminjaman terhubung ke kolom (U-04)`).
3. Uji ulang halaman yang diperbaiki dengan Lighthouse dan keyboard, lalu perbarui kolom Status.
4. Temuan yang tidak diperbaiki harus ada alasannya di bagian Keputusan.
5. Lampirkan laporan akhir dan screenshot sebelum/sesudah sebagai bukti kualitas.
