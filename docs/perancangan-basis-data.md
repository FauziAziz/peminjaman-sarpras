# Perancangan Basis Data dan Struktur Tabel

## 2.5.1 Entity Relationship Diagram (ERD)
Entity Relationship Diagram (ERD) menggambarkan pemodelan konseptual dari struktur data dan relasi antar tabel dalam database aplikasi pencatatan peminjaman sarpras. ERD memastikan integritas data dan mencegah terjadinya redundansi. Visualisasi lengkap ERD tersimpan pada `docs/diagram-laporan.md`.

## 2.5.2 Struktur Tabel dan Realisasi Database
Database aplikasi diberi nama `peminjaman_sarpras` dengan standar penyimpanan `utf8mb4_unicode_ci`. Seluruh nama tabel dan kolom menggunakan bahasa Indonesia, dengan primary key berformat `id_<tabel>`.

Berikut rincian struktur tabel yang direalisasikan ke dalam sistem:

1. **Tabel `level`**
   - `id_level` (BigInt, PK)
   - `nama_level` (Varchar, Unik) — Nilai: `admin`, `operator`.

2. **Tabel `petugas`**
   - `id_petugas` (BigInt, PK)
   - `username` (Varchar, Unik)
   - `password` (Varchar, Hash)
   - `nama_petugas` (Varchar)
   - `id_level` (BigInt, FK ke `level.id_level`)

3. **Tabel `kategori`**
   - `id_kategori` (BigInt, PK)
   - `nama_kategori` (Varchar, Unik)
   - `kode_kategori` (Varchar, Unik)
   - `keterangan` (Text, Nullable)

4. **Tabel `ruang`**
   - `id_ruang` (BigInt, PK)
   - `nama_ruang` (Varchar, Unik)
   - `kode_ruang` (Varchar, Unik)
   - `keterangan` (Text, Nullable)

5. **Tabel `inventaris`**
   - `id_inventaris` (BigInt, PK)
   - `kode_inventaris` (Varchar, Unik)
   - `nama` (Varchar)
   - `id_kategori` (BigInt, FK ke `kategori.id_kategori`)
   - `id_ruang` (BigInt, FK ke `ruang.id_ruang`, Nullable)
   - `jumlah` (Integer)
   - `kondisi` (Enum: `baik`, `rusak ringan`, `rusak berat`)
   - `keterangan` (Text, Nullable)
   - `tanggal_register` (Date)
   - `id_petugas` (BigInt, FK ke `petugas.id_petugas`)

6. **Tabel `peminjam`**
   - `id_peminjam` (BigInt, PK)
   - `nama_peminjam` (Varchar)
   - `jabatan` (Varchar)
   - `aktif` (Boolean, Default: `true`)

7. **Tabel `peminjaman`**
   - `id_peminjaman` (BigInt, PK)
   - `id_peminjam` (BigInt, FK ke `peminjam.id_peminjam`)
   - `id_petugas` (BigInt, FK ke `petugas.id_petugas`)
   - `tanggal_pinjam` (Date)
   - `tanggal_kembali` (Date, Nullable)
   - `status_peminjaman` (Enum: `dipinjam`, `kembali`)

8. **Tabel `detail_pinjam`**
   - `id_detail_pinjam` (BigInt, PK)
   - `id_peminjaman` (BigInt, FK ke `peminjaman.id_peminjaman`)
   - `id_inventaris` (BigInt, FK ke `inventaris.id_inventaris`)
   - `jumlah` (Integer)

*Catatan Aturan Unik & Integritas:*
- Seluruh Foreign Key menggunakan aturan `RESTRICT` agar data master yang sedang digunakan tidak dapat dihapus secara langsung.
- Menerapkan validasi anti-duplikat dua lapis (Validasi FormRequest Laravel + Unique Index Database) untuk menghindari duplikasi data pada kolom sensitif.
