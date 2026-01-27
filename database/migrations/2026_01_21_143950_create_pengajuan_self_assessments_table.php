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
       Schema::create('pengajuan_self_assessments', function (Blueprint $table) {
        $table->id();
       $table->foreignId('pengajuan_skema_id')
      ->constrained('pengajuan_skema')
      ->cascadeOnDelete();
        $table->foreignId('kriteria_unjuk_kerja_id')
        ->constrained('kriteria_unjuk_kerja')
        ->cascadeOnDelete();
        $table->enum('nilai', ['K', 'BK']);
        $table->timestamps();
        $table->unique(
        ['pengajuan_skema_id', 'kriteria_unjuk_kerja_id'],
        'psa_pengajuan_kuk_unique'
        );

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_self_assessments');
    }
};
