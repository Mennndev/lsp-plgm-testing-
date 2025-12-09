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
        Schema::create('pengajuan_dokumen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_skema_id')->constrained('pengajuan_skema')->onDelete('cascade');
            $table->enum('jenis_dokumen', ['portfolio', 'sertifikat', 'cv', 'ktp', 'ijazah', 'lainnya']);
            $table->string('nama_file');
            $table->string('path');
            $table->unsignedInteger('ukuran'); // in bytes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_dokumen');
    }
};
