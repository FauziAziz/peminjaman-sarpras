# DESIGN.md: Panduan Desain Antarmuka

Aplikasi inventaris sarana dan prasarana (peminjaman barang) berbasis Laravel 13, template AdminLTE 4 dengan aset lokal.

## Cara memakai dokumen ini

- Dokumen ini adalah sumber keputusan tampilan. Agent wajib membacanya sebelum mengubah antarmuka dan tidak boleh menambah warna, font, atau gaya di luar isi dokumen ini.
- Perubahan isi dokumen hanya dilakukan atas persetujuan pemilik proyek.
- Item bertanda **[USULAN]** belum disetujui dan boleh diubah. Item bertanda **[PUTUSKAN]** menunggu keputusan pemilik proyek; agent tidak boleh memilih sendiri.
- Aturan lingkup milestone di `AGENTS.md` tetap berlaku. Dokumen ini tidak memberi izin untuk mengubah fitur atau logika.

---

## 1. Konteks pengguna

- Pengguna aplikasi adalah petugas: **admin** (mengelola data induk dan data user) dan **operator** (mencatat peminjaman dan pengembalian).
- Peminjam tidak login. Data peminjam (nama, jabatan, aktif atau tidak) hanya ada untuk mempermudah pengisian.
- Aplikasi adalah alat bantu mencatat, bukan aplikasi untuk meminjam. Operator mengulang tugas yang sama berulang kali, sehingga kecepatan dan kejelasan lebih penting daripada hiasan.
- Aplikasi berjalan di localhost dan harus tetap berfungsi tanpa internet (semua aset lokal).

## 2. Prinsip desain **[USULAN]**

1. **Tenang**: warna lembut, sedikit hiasan, tidak ada elemen yang bersaing merebut perhatian.
2. **Jelas**: satu aksi utama per halaman, label berupa kata kerja, status selalu berupa teks.
3. **Cepat**: kursor langsung di kolom yang paling sering diisi, nilai awal yang masuk akal, pencarian dan filter berjalan otomatis tanpa tombol terapkan.

## 3. Warna

### 3.1 Palet dasar (dibuat pemilik proyek)

`#FEFEFE`, `#EBE7D9`, `#3876B4`, `#4EC0F7`, `#B4C894`

### 3.2 Token warna

Warna di luar palet dasar adalah pelengkap yang ditambahkan agar kontras memenuhi WCAG 2.2 AA (teks biasa 4,5:1; elemen antarmuka 3:1). Semua rasio sudah dihitung.

| Token | Hex | Dipakai untuk | Kontras |
|---|---|---|---|
| latar-halaman | `#EBE7D9` | latar seluruh halaman | |
| permukaan | `#FEFEFE` | kartu, tabel, form, modal | |
| teks | `#1E2A36` | teks utama | 14,46 di putih; 11,78 di krem |
| teks-sekunder | `#4A5560` | keterangan, placeholder | 7,55 di putih; 6,15 di krem |
| utama | `#3876B4` | tombol utama, cincin fokus | putih di atasnya 4,71 |
| utama-hover | `#244F7A` | hover dan tekan tombol utama | putih di atasnya 8,41 |
| tautan | `#2B5E91` | link dan teks berwarna biru | 6,69 di putih; 5,45 di krem |
| aksen | `#4EC0F7` | sorotan, penanda menu aktif, badge "Dipinjam" | dengan teks `#1E2A36`: 7,09 |
| sage | `#B4C894` | badge "Dikembalikan" | dengan teks `#1E2A36`: 8,08 |
| sukses | `#3F7D3A` | notifikasi berhasil | putih di atasnya 4,95 |
| peringatan | `#F2C14E` | stok menipis | dengan teks `#1E2A36`: 8,69 |
| bahaya | `#B3382C` | error, terlambat, tombol hapus | putih di atasnya 5,92 |
| garis | `#D6D1BF` | pemisah dekoratif (bukan batas input) | |
| batas-input | `#737C87` | batas input dan kontrol form | 4,20 di putih; 3,42 di krem |
| baris-hover | `#E3F4FD` | sorotan baris tabel saat hover | teks di atasnya 12,94 |

### 3.3 Sidebar (biru)

| Elemen | Warna | Kontras |
|---|---|---|
| Latar sidebar | `#2B5E91` | |
| Teks dan ikon menu | `#FEFEFE` | 6,69 |
| Judul bagian dan teks redup | `#D5E2F0` | 5,13 |
| Menu hover | latar `#244F7A`, teks `#FEFEFE` | 8,41 |
| Menu aktif | latar `#1F4469`, teks `#FEFEFE`, garis kiri 4px `#4EC0F7` | 9,97; garis terhadap latar 4,89 |
| Cincin fokus di sidebar | `#FEFEFE`, tebal 2px | 6,69 |

### 3.4 Status

Status selalu memakai label teks; warna hanya pendukung.

| Status | Tampilan |
|---|---|
| Dipinjam | latar `#4EC0F7`, teks `#1E2A36`, label "Dipinjam" |
| Dikembalikan | latar `#B4C894`, teks `#1E2A36`, label "Dikembalikan" |
| Terlambat | latar `#B3382C`, teks `#FEFEFE`, label "Terlambat" |
| Stok menipis | latar `#F2C14E`, teks `#1E2A36`, label "Stok menipis" |

### 3.5 Aturan pemakaian warna

- Hanya `utama`, `tautan`, `teks`, dan `teks-sekunder` yang boleh menjadi warna teks di atas latar terang.
- `aksen` dan `sage` hanya sebagai latar dengan teks gelap, tidak pernah sebagai warna teks atau teks putih di atasnya (putih di atas aksen 2,04; di atas sage 1,79; keduanya gagal).
- Cincin fokus pada konten memakai `utama` (di putih 4,71; di krem 3,84).
- Tidak ada gradien dan tidak ada warna baru di luar token tanpa persetujuan.

### 3.6 Alasan keputusan warna

- Biru `#3876B4` lolos untuk teks putih (4,71), tetapi sebagai teks di atas krem hanya 3,84, maka link memakai `#2B5E91`.
- Palet dasar tidak punya warna gelap, sukses, peringatan, dan bahaya; ketiganya dilengkapi dan dihitung kontrasnya.
- Batas input minimal 3:1 terhadap latar (WCAG 1.4.11), maka tidak memakai warna garis dekoratif.

## 4. Tipografi, bentuk, dan jarak

| Aspek | Keputusan sementara | Status |
|---|---|---|
| Font | Font bawaan template/sistem; tidak menambah font baru agar tetap berjalan tanpa internet | **[PUTUSKAN]** |
| Ukuran teks isi | 16px (1rem); ukuran minimum 14px untuk keterangan | **[USULAN]** |
| Sudut | Satu nilai radius untuk seluruh komponen (nilai bawaan Bootstrap) | **[PUTUSKAN]** |
| Bayangan | Minimal; hanya pada kartu dan modal, tidak pada tombol dan badge | **[USULAN]** |
| Jarak | Mengikuti skala jarak Bootstrap; tabel dirapatkan karena operator banyak membaca daftar | **[USULAN]** |

## 5. Komponen dan pola

### Tombol
- Satu tombol utama per halaman atau per form; tombol lain bergaya sekunder.
- Label berupa kata kerja yang spesifik: "Catat Peminjaman", "Simpan Barang", "Ekspor Riwayat". Hindari "Submit" dan "OK".
- Tombol hapus memakai warna `bahaya` dan selalu meminta konfirmasi yang menyebut nama item ("Hapus kategori 'Elektronik'?").

### Tabel
- Aksi baris selalu di kolom paling kanan dengan urutan yang sama di semua halaman.
- Baris menyorot dengan `baris-hover`; status memakai badge pada bagian 3.4.
- Tampilan kosong yang menuntun, misalnya: "Belum ada peminjaman hari ini. Klik Catat Peminjaman untuk memulai."
- Pencarian dan filter kategori berjalan otomatis tanpa tombol terapkan.

### Form
- Label di atas kolom dan selalu terlihat (placeholder bukan pengganti label).
- Kursor otomatis di kolom pertama; tanggal terisi hari ini; peminjam dipilih lewat pencarian.
- Pesan error muncul di dekat kolomnya dan menyebut masalah serta cara memperbaikinya.

### Notifikasi
- Setelah tiap aksi tampil pesan singkat (sukses atau gagal) yang menyebut apa yang terjadi.

### Dashboard
- Hanya informasi yang berguna bagi operator (barang yang sedang dipinjam, perlu dikembalikan, stok menipis). Tidak ada kartu statistik hiasan dan tidak ada angka karangan.

### Ekspor
- Rentang waktu dapat dipilih (1 hari sampai 1 tahun) dan filter status memengaruhi isi berkas. Pilihannya harus ramah pengguna.

## 6. Bahasa antarmuka **[USULAN]**

- Bahasa Indonesia baku yang ringkas, tanpa campuran bahasa Inggris pada label, tombol, dan pesan.
- Kalimat langsung dan faktual; tanpa seruan, emoji, atau nada promosi.
- Istilah konsisten di seluruh aplikasi (misalnya selalu "Peminjaman" dan "Pengembalian", tidak berganti-ganti).

## 7. Aksesibilitas

- Target: WCAG 2.2 level AA.
- Fokus keyboard selalu terlihat (tebal 2px); urutan Tab mengikuti urutan visual.
- Tombol atau link yang hanya berisi ikon wajib punya `aria-label` berbahasa Indonesia; ikon yang mendampingi teks diberi `aria-hidden="true"`.
- Setiap kolom form punya `<label>` terhubung.
- Ukuran target sentuh minimal 24 x 24 piksel CSS; tombol utama sebaiknya lebih besar.
- Informasi tidak boleh hanya dibedakan dengan warna.

## 8. Hal yang dihindari

- Ikon dekoratif berlebihan, emoji di antarmuka dan kode, gradien, semua elemen berbayang dan bulat.
- Data contoh generik ("Test 1", "Item A"); gunakan data yang realistis (misalnya "Proyektor Epson EB-X06", "Lab RPL 1").
- Kartu statistik karangan, teks pembuka atau penutup yang bertele-tele, dan komentar kode yang hanya mengulang isi kode.
- Fitur dan elemen di luar kebutuhan soal.

## 9. Catatan teknis

- AdminLTE 4 sudah membundel CSS Bootstrap 5.3 di dalam `adminlte.min.css`; `bootstrap.min.css` tidak perlu dimuat terpisah. JS Bootstrap tetap dimuat.
- Gaya kustom ditulis di satu berkas CSS kustom yang dimuat **setelah** CSS AdminLTE. Token warna didefinisikan sebagai variabel pada `:root`, lalu menimpa variabel Bootstrap/AdminLTE yang benar-benar ada di berkas vendor (jangan menebak nama variabel).
- Jangan mengedit berkas di `public/vendor`.
- Hasil audit Lighthouse dan temuan perbaikannya dicatat di `docs/laporan-ux.md`.

## 10. Keputusan terbuka

| Keputusan | Pilihan | Keputusan pemilik |
|---|---|---|
| Font | bawaan template/sistem, atau font lokal tambahan | |
| Radius sudut | bawaan Bootstrap, atau lebih tegas/lebih bulat | |
| Nama aplikasi dan identitas sekolah (nama, logo) di halaman login dan sidebar | | |
| Gaya bahasa antarmuka | baku ringkas (usulan), atau lain | |

## 11. Riwayat perubahan

| Tanggal | Perubahan |
|---|---|
| 2026-11-16 | Draf awal: konteks, prinsip, palet dan sidebar biru, pola komponen, aksesibilitas |

5.2 Tampilan HP (lebar di bawah 768px) [USULAN]:
### Tampilan HP (lebar di bawah 768px)
- Daftar yang punya aksi (Pengembalian, Riwayat) ditampilkan sebagai kartu bertumpuk, satu kartu per baris: nama tebal, detail kecil, badge status, dan tombol aksi (misalnya "Kembalikan") selalu terlihat tanpa geser horizontal.
- Tabel data induk boleh tetap berbentuk tabel, tetapi dibungkus table-responsive, kolom "No" disembunyikan, dan padding kartu dikurangi.
- Toolbar (pencarian dan tombol tambah) ditumpuk: pencarian selebar layar, tombol di bawahnya selebar layar.
- Baris barang pada form peminjaman menjadi kartu mini (pilih barang penuh lebar, jumlah, tombol hapus), bukan tabel.
- Tombol aksi utama selebar layar dengan ukuran huruf seragam. Aksi sekunder (misalnya "Tambah Barang") bergaya outline `utama`.
- Tidak ada elemen yang melebihi lebar kartu. Tidak boleh ada scroll horizontal pada halaman, kecuali di dalam kontainer tabel yang sengaja dibuat responsif.
- Garis tabel memakai token garis; hanya batas input yang memakai batas-input.
- Target sentuh minimal 44px untuk tombol dan ikon yang bisa diketuk.

[textlink](http://peminjaman-sarpras.test/dashboard)