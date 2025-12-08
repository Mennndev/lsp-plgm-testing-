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
        Schema::create('profesi_terkaits', function (Blueprint $table) {
            $table->id();

            $table->foreignId('program_pelatihan_id')
                  ->constrained('program_pelatihans')
                  ->cascadeOnDelete();

            $table->string('nama'); // "Operator Komputer", "Staf Entri Data", dst.

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profesi_terkaits');
    }
};
