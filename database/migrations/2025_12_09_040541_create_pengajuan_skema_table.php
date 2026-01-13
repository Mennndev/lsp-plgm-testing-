<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::create('pengajuan_skema', function (Blueprint $table) {
        $table->id();

        // JANGAN gunakan integer(). Gunakan foreignId().
        // Ini otomatis membuat kolom BIGINT UNSIGNED dan sinkron dengan tabel users
        $table->foreignId('user_id')
              ->constrained('users') // Merujuk ke tabel users
              ->onDelete('cascade');

        $table->foreignId('program_pelatihan_id')
              ->constrained('program_pelatihans')
              ->onDelete('cascade');

        $table->enum('status', ['draft', 'pending', 'approved', 'rejected'])
              ->default('draft');

        $table->timestamp('tanggal_pengajuan')->nullable();
        $table->timestamp('tanggal_disetujui')->nullable();
        $table->text('catatan_admin')->nullable();

        // Untuk approved_by, karena bisa kosong (nullable)
        $table->foreignId('approved_by')
              ->nullable()
              ->constrained('users')
              ->onDelete('set null');

        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_skema');
    }
};
