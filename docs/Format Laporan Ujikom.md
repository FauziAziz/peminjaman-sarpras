APLIKASI INVENYTARIS SARANA DAN PRASARANA

(Laporan Uji Kompetensi Kejuruan)



Disusun Untuk Memenuhi Salah Satu Persyaratan Kelulusan

Tahun Ajaran 2026/2027









Oleh,

Culley

6666





















BIDANG KEAHLIAN TEKNOLOGI INFORMASI

PROGRAM KEAHLIAN PENGEMBANGAN PERANGKAT 

LUNAK DAN GIM

KONSENTRASI KEAHLIAN REKAYASA PERANGKAT LUNAK

SMK BAKTI NUSANTARA 666

2026

KATA PENGANTAR





Puji syukur penulis panjatkan kehadirat Tuhan Yang Maha Esa sehingga pada akhirnya penulis dapat menyusun dan menyelesaikan laporan Uji Kompetensi Kejuruan dan diselesaikan sesuai rencana.

Ujikom ini dilaksanakan untuk memenuhi salah satu persyaratan kelulusan yang telah ditentukan oleh SMK Bakti Nusantara 666.

Dalam penyusunan laporan ini penulis banyak mendapatkan motivasi, semangat dan bantuan dari berbagai pihak. Untuk itu pada kesempatan ini penulis ingin mengucapkan terimakasih kepada:

- Ibu Dini Susanti, S.Pd.,M.M. selaku Kepala SMK Bakti Nusantara 666  yang telah memberikan dukungan.

- Bapak Aji Sukma Kusumah, S.T. selaku Kepala Program Keahlian ...

- Bapak/Ibu guru kejuruan yang telah membimbing pembelajaran selama tiga tahun.

- Semua pihak yang telah membantu yang tidak bisa penulis sebutkan namanya satu persatu.

Penulis menyadari bahwa dalam penulisan laporan ini masih jauh dari sempurna, oleh karena itu penulis mengharapkan adanya kritik dan saran yang bersifat membangun dari pembaca demi kesempurnaan laporan ini.

Akhir   kata   penulis   mengharapkan   semoga   laporan   Uji Kompetensi Kejuruan   ini memperluas pengetahuan kita semua tentang pentingnya sebuah Uji Kompetensi Kejuruan.



Kab. Bandung, 19 Oktober 2026







                                                                   Penulis





# DAFTAR ISI



DAFTAR ISI	i

DAFTAR GAMBAR	iii

DAFTAR TABEL	iv

BAB I PENDAHULUAN	1

1.1	Latar Belakang	1

1.2	Identifikasi Masalah	1

1.3	Rumusan Masalah	1

1.4	Tujuan Pembuatan Aplikasi	1

1.5	Manfaat Pembuatan Aplikasi	1

1.6	Batasan Masalah	1

BAB II LANDASAN TEORI DAN PERANCANGAN SISTEM	2

2.1	Landasan Teori	2

2.1.1	Pengertian Sistem Informasi	2

2.1.2	Pengertian Inventaris Sarana dan Prasarana (Contoh)	2

2.1.3	Pengertian Aplikasi Berbasis Web/Mobile	2

2.1.4	Bahasa Pemograman yang Digunakan	2

2.1.5	Database Management System (DBMS)	2

2.1.6	Object Oriented Programming (OOP)	2

2.1.7	Pengertian Flowchart	2

2.1.8	Pengertian Unfied Modeling Keras (UML)	2

2.1.9	Pengertian Entity Relationship Diagram (ERD)	2

2.2	Analisis Kebutuhan Sistem	2

2.2.1	Kenutuhan Perangkat Keras (Hardware)	2

2.2.2	Kebutuhan Perangkat Lunak (Software)	2

2.3	Analisis Hak Akses	2

2.3.1	Administrator (Contoh)	2

2.3.2	Operator (Contoh)	2

2.3.3	Peminjam (Contoh)	2

2.4	Perancangan Alur Sistem	2

2.4.1	Flowcart Sistem	2

2.4.2	Use Case Diagram	2

2.5	Perancangan Basis Data	2

2.5.1	Entity Relationship Diagram (ERD)	2

2.5.2	Struktur Tabel dan Realisasi	2

BAB III IMPLEMENTASI DAN PAMDUAN PENGGUNAAN APLIKASI	3

3.1	Implementasi Basis Data	3

3.1.1	Pembuatan Data Base	3

3.1.2	Imolementasi Tabel dan Realisasi	3

3.1.3	Koneksi Aplikasi dengan Database	3

3.2	Implementasi Antarmuka Aplikasi	3

3.2.1	Tampilan Halaman Login	3

3.2.2	Tampilan Halaman Dasboart	3

3.2.3	Tampilan Halaman Inventaris	3

3.2.4	Tampilan Halaman Peminjaman	3

3.2.5	Tampilan Halaman Pengambilan	3

3.2.6	Tampilan Halaman Laporan	3

3.3	Panduan Penggunaan Aplikasi	3

3.3.1	Penggunaan Login (Sesuai Hak Akses)	3

3.3.2	Fungsi Dasboart (Sesuai Hak Akses)	3

3.3.3	Penggunaan Halaman Inventari (Sesuai Hak Akses)	3

3.3.4	Penggunaan Halaman Peminjaman (Sesuai Hak Akses)	3

3.3.5	Penggunaan Halaman Pengembalian (Sesuai Hak Akses)	3

3.3.6	Penggunaan HAlaman Laporan (Sesuai Hak Akses)	3

BAB IV PENUTUP	4

4.1	Kesimpulan	4

LAMPIRAN	5



	

	

# DAFTAR GAMBAR

# DAFTAR TABEL

# 
PENDAHULUAN

## Latar Belakang

## Identifikasi Masalah

## Rumusan Masalah

## Tujuan Pembuatan Aplikasi

## Manfaat Pembuatan Aplikasi

## Batasan Masalah

# 
LANDASAN TEORI DAN PERANCANGAN SISTEM

## Landasan Teori

### Pengertian Sistem Informasi

### Pengertian Inventaris Sarana dan Prasarana atau Restoran

### Pengertian Aplikasi Berbasis Web/Mobile

### Bahasa Pemograman yang Digunakan

### Database Management System (DBMS)

### Object Oriented Programming (OOP)

### Pengertian Flowchart

### Pengertian Unfied Modeling Keras (UML)

### Pengertian Entity Relationship Diagram (ERD)

## Analisis Kebutuhan Sistem

### Kenutuhan Perangkat Keras (Hardware)

### Kebutuhan Perangkat Lunak (Software)

## Analisis Hak Akses

### Administrator (Contoh)

### Operator (Contoh)

### Peminjam (Contoh)

## Perancangan Alur Sistem

### Flowcart Sistem

### Use Case Diagram

## Perancangan Basis Data

### Entity Relationship Diagram (ERD)

### Struktur Tabel dan Realisasi



# 
IMPLEMENTASI DAN PAMDUAN PENGGUNAAN APLIKASI

## Implementasi Basis Data

### Pembuatan Data Base

### Imolementasi Tabel dan Realisasi

### Koneksi Aplikasi dengan Database

## Implementasi Antarmuka Aplikasi

### Tampilan Halaman Login

### Tampilan Halaman Dasboart

### Tampilan Halaman Inventaris

### Tampilan Halaman Peminjaman

### Tampilan Halaman Pengambilan

### Tampilan Halaman Laporan

## Panduan Penggunaan Aplikasi

### Penggunaan Login (Sesuai Hak Akses)

### Fungsi Dasboart (Sesuai Hak Akses)

### Penggunaan Halaman Inventari (Sesuai Hak Akses)

### Penggunaan Halaman Peminjaman (Sesuai Hak Akses)

### Penggunaan Halaman Pengembalian (Sesuai Hak Akses)

### Penggunaan HAlaman Laporan (Sesuai Hak Akses)

# 
PENUTUP

## Kesimpulan

# LAMPIRAN

