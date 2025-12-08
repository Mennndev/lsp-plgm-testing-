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
        Schema::create('unit_kompetensis', function (Blueprint $table) {
            $table->id();

            $table->foreignId('program_pelatihan_id')
                  ->constrained('program_pelatihans')
                  ->cascadeOnDelete();

            $table->unsignedInteger('no_urut')->default(1);   // no: 1,2,3...
            $table->string('kode_unit');                      // J.63OPR00.002.2
            $table->string('judul_unit');                     // Menggunakan Perangkat Komputer

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unit_kompetensis');
    }
};
