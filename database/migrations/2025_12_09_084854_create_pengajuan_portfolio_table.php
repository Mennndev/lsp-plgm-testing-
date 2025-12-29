<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema:: create('pengajuan_portfolio', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('pengajuan_skema_id');
            $table->foreign('pengajuan_skema_id')
                  ->references('id')
                  ->on('pengajuan_skema')
                  ->onDelete('cascade');

            $table->unsignedBigInteger('unit_kompetensi_id');
            $table->foreign('unit_kompetensi_id')
                  ->references('id')
                  ->on('unit_kompetensis')
                  ->onDelete('cascade');

            $table->string('nama_file');
            $table->string('path');
            $table->unsignedBigInteger('ukuran'); // dalam bytes
            $table->string('tipe_file'); // pdf, jpg, png, docx
            $table->text('deskripsi')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_portfolio');
    }
};
