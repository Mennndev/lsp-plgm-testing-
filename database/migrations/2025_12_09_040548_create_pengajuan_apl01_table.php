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
        Schema::create('pengajuan_apl01', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_skema_id')->constrained('pengajuan_skema')->onDelete('cascade');
            $table->string('nama_lengkap');
            $table->string('nik', 16);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('kebangsaan')->default('Indonesia');
            $table->text('alamat_rumah');
            $table->string('kode_pos', 10)->nullable();
            $table->string('telepon_rumah', 20)->nullable();
            $table->string('telepon_kantor', 20)->nullable();
            $table->string('email');
            $table->string('kualifikasi_pendidikan')->nullable();
            $table->string('nama_institusi')->nullable();
            $table->string('jabatan')->nullable();
            $table->text('alamat_kantor')->nullable();
            $table->string('telepon_kantor_pekerjaan', 20)->nullable();
            $table->string('fax', 20)->nullable();
            $table->string('email_kantor')->nullable();
            $table->string('nama_sertifikat')->nullable();
            $table->string('nomor_sertifikat')->nullable();
            $table->json('tujuan_asesmen')->nullable(); // PKT, RPL, RCC, Lainnya
            $table->text('bukti_penyertaan_dasar')->nullable();
            $table->text('bukti_administrasif')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_apl01');
    }
};
