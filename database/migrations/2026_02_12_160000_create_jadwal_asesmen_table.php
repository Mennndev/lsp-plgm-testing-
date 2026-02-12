<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_asesmen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_skema_id')
                ->constrained('pengajuan_skema')
                ->cascadeOnDelete();
            $table->foreignId('asesor_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->foreignId('created_by')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->dateTime('tanggal_mulai');
            $table->dateTime('tanggal_selesai')->nullable();
            $table->enum('mode_asesmen', ['offline', 'online'])->default('offline');
            $table->string('lokasi')->nullable();
            $table->string('tautan_meeting')->nullable();
            $table->enum('status', ['scheduled', 'completed', 'postponed', 'cancelled'])->default('scheduled');
            $table->text('catatan')->nullable();
            $table->unsignedInteger('reschedule_count')->default(0);
            $table->timestamp('last_rescheduled_at')->nullable();
            $table->timestamps();

            $table->unique('pengajuan_skema_id');
            $table->index(['tanggal_mulai', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_asesmen');
    }
};
