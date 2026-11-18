# Struktur Tabel Database Peminjaman Sarpras

Berikut adalah rincian struktur tabel dan relasi database yang digunakan dalam aplikasi:

## 1. Tabel `level`
| Kolom | Tipe Data | Keterangan |
|---|---|---|
| `id_level` | BigInt | Primary Key |
| `nama_level` | Varchar | Unik (Nilai: `admin`, `operator`) |

## 2. Tabel `petugas`
| Kolom | Tipe Data | Keterangan |
|---|---|---|
| `id_petugas` | BigInt | Primary Key |
| `username` | Varchar | Unik |
| `password` | Varchar | Hash |
| `nama_petugas` | Varchar | - |
| `id_level` | BigInt | Foreign Key ke `level.id_level` |

## 3. Tabel `kategori`
| Kolom | Tipe Data | Keterangan |
|---|---|---|
| `id_kategori` | BigInt | Primary Key |
| `nama_kategori` | Varchar | Unik |
| `kode_kategori` | Varchar | Unik |
| `keterangan` | Text | Nullable |

## 4. Tabel `ruang`
| Kolom | Tipe Data | Keterangan |
|---|---|---|
| `id_ruang` | BigInt | Primary Key |
| `nama_ruang` | Varchar | Unik |
| `kode_ruang` | Varchar | Unik |
| `keterangan` | Text | Nullable |

## 5. Tabel `inventaris`
| Kolom | Tipe Data | Keterangan |
|---|---|---|
| `id_inventaris` | BigInt | Primary Key |
| `kode_inventaris` | Varchar | Unik |
| `nama` | Varchar | - |
| `id_kategori` | BigInt | Foreign Key ke `kategori.id_kategori` |
| `id_ruang` | BigInt | Foreign Key ke `ruang.id_ruang` (Nullable) |
| `jumlah` | Integer | - |
| `kondisi` | Enum | Nilai: `baik`, `rusak ringan`, `rusak berat` |
| `keterangan` | Text | Nullable |
| `tanggal_register` | Date | - |
| `id_petugas` | BigInt | Foreign Key ke `petugas.id_petugas` |

## 6. Tabel `peminjam`
| Kolom | Tipe Data | Keterangan |
|---|---|---|
| `id_peminjam` | BigInt | Primary Key |
| `nama_peminjam` | Varchar | - |
| `jabatan` | Varchar | - |
| `aktif` | Boolean | Default: `true` |

## 7. Tabel `peminjaman`
| Kolom | Tipe Data | Keterangan |
|---|---|---|
| `id_peminjaman` | BigInt | Primary Key |
| `id_peminjam` | BigInt | Foreign Key ke `peminjam.id_peminjam` |
| `id_petugas` | BigInt | Foreign Key ke `petugas.id_petugas` |
| `tanggal_pinjam` | Date | - |
| `tanggal_kembali` | Date | Nullable |
| `status_peminjaman` | Enum | Nilai: `dipinjam`, `kembali` |

## 8. Tabel `detail_pinjam`
| Kolom | Tipe Data | Keterangan |
|---|---|---|
| `id_detail_pinjam` | BigInt | Primary Key |
| `id_peminjaman` | BigInt | Foreign Key ke `peminjaman.id_peminjaman` |
| `id_inventaris` | BigInt | Foreign Key ke `inventaris.id_inventaris` |
| `jumlah` | Integer | - |
