---
description: Kerjakan rencana milestone yang sudah disetujui, lalu tulis penjelasan
agent: build
---
Laksanakan rencana milestone $ARGUMENTS yang baru saja disetujui pengguna di
percakapan ini. Kerjakan sesuai rencana, tidak lebih dan tidak kurang.

LANGKAH 0 (cek lingkup, sebelum menulis apa pun): bandingkan daftar file dan
pekerjaan di rencana dengan baris milestone ini di @docs/08-rencana-milestone.md.
Jika ada yang di luar lingkup, BERHENTI dan laporkan ke pengguna. Jangan
mengerjakan bagian itu.

Aturan: patuhi @AGENTS.md dan @docs/07-konvensi-kode.md. Jangan memasang paket,
jangan menjalankan perintah destruktif, jangan melakukan git commit.

Setelah implementasi selesai:
1. Berikan daftar uji manual (langkah dan hasil yang diharapkan).
2. Tulis catatan penjelasan ke docs/penjelasan/ memakai format
   @docs/penjelasan/_template.md (apa yang dibuat, kenapa, alur kode, cara uji,
   pertanyaan ujian yang mungkin muncul, contoh modifikasi). Jangan menulis
   password atau data rahasia di sana.
3. Perbarui docs/progress.md: ubah HANYA kolom status baris milestone ini
   menjadi "Menunggu review". Jangan mengubah struktur file dan jangan menulis
   "Selesai"; itu hak pengguna.
4. Sebutkan file yang kamu sentuh, lalu BERHENTI dan tunggu persetujuan
   pengguna sebelum milestone berikutnya.
