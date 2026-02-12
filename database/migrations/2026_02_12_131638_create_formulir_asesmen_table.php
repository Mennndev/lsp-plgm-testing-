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
        Schema::create('formulir_asesmen', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('pengajuan_skema_id')
                  ->constrained('pengajuan_skema')
                  ->cascadeOnDelete();
            
            $table->foreignId('asesor_id')
                  ->constrained('users')
                  ->cascadeOnDelete();
            
            $table->string('jenis_formulir'); // FR_IA_01, FR_IA_02, etc.
            $table->text('data')->nullable(); // JSON data for form fields
            $table->enum('status', ['draft', 'selesai'])->default('draft');
            
            $table->timestamps();
            
            // Unique constraint: one form per type per pengajuan per asesor
            $table->unique(['pengajuan_skema_id', 'asesor_id', 'jenis_formulir']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formulir_asesmen');
    }
};
