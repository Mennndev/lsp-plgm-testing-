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
        Schema::create('pengajuan_apl02', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_skema_id')->constrained('pengajuan_skema')->onDelete('cascade');
            $table->foreignId('unit_kompetensi_id')->constrained('unit_kompetensis')->onDelete('cascade');
            $table->json('self_assessment')->nullable(); // array of {kriteria_id, status: 'K'/'BK', bukti}
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_apl02');
    }
};
