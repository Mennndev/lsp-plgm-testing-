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
        Schema::create('bukti_administratif', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_pelatihan_id')
                  ->constrained('program_pelatihans')
                  ->cascadeOnDelete();
            $table->string('nama_dokumen'); // "Copy KTP", "Pas Foto (3x4) Background Merah"
            $table->enum('tipe_dokumen', ['file_upload', 'text', 'checkbox'])->default('file_upload');
            $table->boolean('is_wajib')->default(true);
            $table->unsignedInteger('urutan')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukti_administratif');
    }
};
