<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('level', function (Blueprint $table) {
            $table->id('id_level');
            $table->string('nama_level')->unique();
        });

        Schema::create('petugas', function (Blueprint $table) {
            $table->id('id_petugas');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('nama_petugas');
            $table->foreignId('id_level')->constrained('level', 'id_level')->restrictOnDelete();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('kategori', function (Blueprint $table) {
            $table->id('id_kategori');
            $table->string('nama_kategori')->unique();
            $table->string('kode_kategori')->unique();
            $table->text('keterangan')->nullable();
        });

        Schema::create('ruang', function (Blueprint $table) {
            $table->id('id_ruang');
            $table->string('nama_ruang')->unique();
            $table->string('kode_ruang')->unique();
            $table->text('keterangan')->nullable();
        });

        Schema::create('inventaris', function (Blueprint $table) {
            $table->id('id_inventaris');
            $table->string('kode_inventaris')->unique();
            $table->string('nama');
            $table->foreignId('id_kategori')->constrained('kategori', 'id_kategori')->restrictOnDelete();
            $table->foreignId('id_ruang')->nullable()->constrained('ruang', 'id_ruang')->restrictOnDelete();
            $table->integer('jumlah')->default(0);
            $table->string('kondisi')->default('baik');
            $table->text('keterangan')->nullable();
            $table->date('tanggal_register');
            $table->foreignId('id_petugas')->constrained('petugas', 'id_petugas')->restrictOnDelete();
            $table->unique(['nama', 'id_kategori']);
        });

        Schema::create('peminjam', function (Blueprint $table) {
            $table->id('id_peminjam');
            $table->string('nama_peminjam');
            $table->string('jabatan');
            $table->boolean('aktif')->default(true);
            $table->unique(['nama_peminjam', 'jabatan']);
        });

        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id('id_peminjaman');
            $table->foreignId('id_peminjam')->constrained('peminjam', 'id_peminjam')->restrictOnDelete();
            $table->foreignId('id_petugas')->constrained('petugas', 'id_petugas')->restrictOnDelete();
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali')->nullable();
            $table->string('status_peminjaman')->default('dipinjam'); // dipinjam, kembali
        });

        Schema::create('detail_pinjam', function (Blueprint $table) {
            $table->id('id_detail_pinjam');
            $table->foreignId('id_peminjaman')->constrained('peminjaman', 'id_peminjaman')->restrictOnDelete();
            $table->foreignId('id_inventaris')->constrained('inventaris', 'id_inventaris')->restrictOnDelete();
            $table->integer('jumlah');
            $table->unique(['id_peminjaman', 'id_inventaris']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_pinjam');
        Schema::dropIfExists('peminjaman');
        Schema::dropIfExists('peminjam');
        Schema::dropIfExists('inventaris');
        Schema::dropIfExists('ruang');
        Schema::dropIfExists('kategori');
        Schema::dropIfExists('petugas');
        Schema::dropIfExists('level');
    }
};
