---
description: Kerjakan rencana milestone yang sudah disetujui, lalu tulis penjelasan
agent: build
---
Laksanakan rencana milestone $ARGUMENTS yang baru saja disetujui pengguna di
percakapan ini. Kerjakan sesuai rencana, tidak lebih dan tidak kurang.

Aturan: patuhi @AGENTS.md dan @docs/07-konvensi-kode.md. Jangan memasang paket,
jangan menjalankan perintah destruktif, jangan melakukan git commit.

Setelah implementasi selesai:
1. Berikan daftar uji manual (langkah dan hasil yang diharapkan).
2. Tulis catatan penjelasan ke docs/penjelasan/ memakai format
   @docs/penjelasan/_template.md (apa yang dibuat, kenapa, alur kode, cara uji,
   pertanyaan ujian yang mungkin muncul, contoh modifikasi).
3. Perbarui docs/progress.md.
4. Sebutkan file yang kamu sentuh, lalu BERHENTI dan tunggu persetujuan
   pengguna sebelum milestone berikutnya.
