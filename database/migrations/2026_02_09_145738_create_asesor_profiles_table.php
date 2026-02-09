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
        Schema::create('asesor_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('alamat')->nullable();
            $table->string('no_ktp', 20)->nullable();
            $table->string('foto_profile')->nullable();
            $table->json('bidang_keahlian')->nullable();
            $table->integer('pengalaman_tahun')->default(0);
            $table->text('riwayat_pendidikan')->nullable();
            $table->string('sertifikat_path')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asesor_profiles');
    }
};
