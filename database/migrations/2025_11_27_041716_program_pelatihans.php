<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
     public function up(): void
    {
        Schema::create('program_pelatihans', function (Blueprint $table) {
            $table->id();

            // Untuk URL & identitas
            $table->string('kode_skema')->unique();     // SKM-IK-01
            $table->string('nama');                     // Operator Komputer Muda
            $table->string('slug')->unique();           // operator-komputer-muda

            // Kategori / Bidang (buat filter di home)
            $table->string('kategori');                 // Informasi dan Komunikasi
            $table->string('kategori_slug');            // informasi (dipakai data-kategori di home)

            // Informasi skema (kartu kiri)
            $table->string('rujukan_skkni')->nullable();       // Permenaker No. ...
            $table->unsignedInteger('jumlah_unit')->default(0);
            $table->unsignedBigInteger('estimasi_biaya')->nullable(); // 1000000
            $table->string('biaya')->default('IDR');      // optional

            // Konten teks
            $table->string('deskripsi_singkat')->nullable();  // untuk card di halaman home
            $table->text('ringkasan')->nullable();            // paragraf di "Ringkasan Skema"

            // Persyaratan & Metode (disimpan per baris)
            $table->text('persyaratan_peserta')->nullable();  // simpan dengan enter tiap poin
            $table->text('metode_asesmen')->nullable();       // simpan dengan enter tiap poin

            // Media
            $table->string('gambar')->nullable();             // path flyer, misal "programs/op-kom-muda.png"
            $table->string('file_panduan')->nullable();       // dokumen panduan (pdf) kalau ada

            $table->boolean('is_published')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('program_pelatihans');
    }
};
