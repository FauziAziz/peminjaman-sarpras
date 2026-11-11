---
description: Periksa hasil milestone terhadap aturan proyek (hanya melapor)
agent: plan
---
Periksa pekerjaan milestone $ARGUMENTS terhadap @AGENTS.md, @docs/03-database.md,
@docs/06-stored-procedure.md, dan @docs/07-konvensi-kode.md.

Laporkan temuan dalam daftar singkat:
- Pelanggaran aturan atau menyimpang dari docs/.
- Kode yang terlalu rumit sehingga sulit dijelaskan saat ujian.
- Anti-duplikat belum dua lapis (validasi Laravel dan unique index).
- Hak akses (middleware level) belum benar atau menu bocor ke role lain.
- Pemakaian CDN, jQuery, atau aset di luar public/vendor.
- File yang diubah di luar lingkup milestone.
- Daftar uji manual atau catatan di docs/penjelasan/ yang belum ada.

Hanya melapor. Jangan mengubah file apa pun.
