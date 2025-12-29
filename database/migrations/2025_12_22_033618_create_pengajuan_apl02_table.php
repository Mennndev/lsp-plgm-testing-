<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pengajuan_apl02', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_skema_id')->constrained('pengajuan_skema')->cascadeOnDelete();
            $table->foreignId('unit_kompetensi_id')->constrained('unit_kompetensis')->cascadeOnDelete();

            // simpan JSON hasil self assessment
            $table->json('self_assessment');

            $table->timestamps();

            $table->index(['pengajuan_skema_id', 'unit_kompetensi_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_apl02');
    }
};
