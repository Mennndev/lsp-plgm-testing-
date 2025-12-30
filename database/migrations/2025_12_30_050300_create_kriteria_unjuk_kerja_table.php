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
        Schema::create('kriteria_unjuk_kerja', function (Blueprint $table) {
            $table->id();
            $table->foreignId('elemen_kompetensi_id')
                  ->constrained('elemen_kompetensis')
                  ->cascadeOnDelete();
            $table->unsignedInteger('no_urut')->default(1);
            $table->text('deskripsi'); // "Mendefinisikan prosedur keamanan informasi yang tepat untuk tiap klasifikasi"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kriteria_unjuk_kerja');
    }
};
