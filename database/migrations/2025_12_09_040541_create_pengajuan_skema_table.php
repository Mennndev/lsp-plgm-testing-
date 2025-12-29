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

            // ✅ PERBAIKAN:  Gunakan integer() TANPA unsigned
            $table->integer('user_id');
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            // program_pelatihan. id = bigint UNSIGNED
            $table->unsignedBigInteger('program_pelatihan_id');
            $table->foreign('program_pelatihan_id')
                  ->references('id')
                  ->on('program_pelatihans')
                  ->onDelete('cascade');

            $table->enum('status', ['draft', 'pending', 'approved', 'rejected'])
                  ->default('draft');

            $table->timestamp('tanggal_pengajuan')->nullable();
            $table->timestamp('tanggal_disetujui')->nullable();
            $table->text('catatan_admin')->nullable();

            // ✅ PERBAIKAN: Gunakan integer() TANPA unsigned
            $table->integer('approved_by')->nullable();
            $table->foreign('approved_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_skema');
    }
};
