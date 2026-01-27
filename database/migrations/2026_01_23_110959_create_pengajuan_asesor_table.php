<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pengajuan_asesor', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pengajuan_skema_id')
                  ->constrained('pengajuan_skema')
                  ->cascadeOnDelete();

            $table->foreignId('asesor_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->string('role')->nullable(); // utama / pendamping / dll

            $table->timestamps();

            $table->unique(['pengajuan_skema_id', 'asesor_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_asesor');
    }
};

