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
        Schema::create('pengajuan_bukti_administratif', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_skema_id')
                  ->constrained('pengajuan_skema')
                  ->cascadeOnDelete();
            $table->foreignId('bukti_administratif_id')
                  ->constrained('bukti_administratif')
                  ->cascadeOnDelete();
            $table->string('nama_file')->nullable();
            $table->string('path')->nullable();
            $table->unsignedBigInteger('ukuran')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_bukti_administratif');
    }
};
