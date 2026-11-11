# 02 — Hak Akses

| Fitur | Admin | Operator |
|---|---|---|
| Login / logout | V | V |
| Kelola user (petugas) | V | X |
| Kelola kategori, ruang, inventaris | V | X |
| Kelola peminjam (tambah, ubah, nonaktifkan) | V | tambah dan lihat saja |
| Lihat daftar barang dan stok tersedia | V | V (hanya lihat) |
| Peminjaman | X | V |
| Pengembalian | X | V |
| Riwayat dan export CSV/Excel | V | V |
| Export data induk (barang, peminjam) | V | X |

Aturan:
- Admin tidak boleh mencatat peminjaman atau pengembalian.
- Operator boleh menambah peminjam baru (tambah cepat saat transaksi), tetapi
  hanya admin yang boleh mengubah atau menonaktifkan peminjam.
- Menu yang bukan hak akses user TIDAK ditampilkan, dan route-nya dijaga
  middleware level (`admin` atau `operator`).
