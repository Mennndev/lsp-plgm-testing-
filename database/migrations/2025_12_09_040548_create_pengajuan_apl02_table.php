<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuan_apl01', function (Blueprint $table) {
            $table->id();

            // pengajuan_skema.id = bigint
            $table->unsignedBigInteger('pengajuan_skema_id');
            $table->foreign('pengajuan_skema_id')
                  ->references('id')
                  ->on('pengajuan_skema')
                  ->onDelete('cascade');

            // Data Pribadi (Bagian A)
            $table->string('nama_lengkap');
            $table->string('nik', 20);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('kebangsaan');
            $table->text('alamat_rumah');
            $table->string('kode_pos', 10)->nullable();
            $table->string('telepon_rumah', 20)->nullable();
            $table->string('hp', 20)->nullable();
            $table->string('email');
            $table->string('kualifikasi_pendidikan')->nullable();

            // Data Pekerjaan (Bagian B)
            $table->string('nama_institusi')->nullable();
            $table->string('jabatan')->nullable();
            $table->text('alamat_kantor')->nullable();
            $table->string('kode_pos_kantor', 10)->nullable();
            $table->string('telepon_kantor', 20)->nullable();
            $table->string('fax', 20)->nullable();
            $table->string('email_kantor')->nullable();

            // Data Sertifikat
            $table->string('nama_sertifikat')->nullable();
            $table->string('nomor_sertifikat')->nullable();

            // Tujuan Asesmen (checkbox)
            $table->json('tujuan_asesmen')->nullable();

            // Bukti Kelengkapan
            $table->text('bukti_penyertaan_dasar')->nullable();
            $table->text('bukti_administrasif')->nullable();
            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema:: dropIfExists('pengajuan_apl01');
    }
};
