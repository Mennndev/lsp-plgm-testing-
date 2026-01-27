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
        Schema::table('pengajuan_skema', function (Blueprint $table) {
    $table->unsignedBigInteger('asesor_id')->nullable()->after('approved_by');

    $table->foreign('asesor_id')
          ->references('id')
          ->on('users')
          ->nullOnDelete();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_skema', function (Blueprint $table) {
            //
        });
    }
};
