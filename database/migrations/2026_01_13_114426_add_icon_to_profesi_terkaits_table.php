<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profesi_terkaits', function (Blueprint $table) {
            $table->string('icon')->nullable()->after('nama');
        });
    }

    public function down(): void
    {
        Schema::table('profesi_terkaits', function (Blueprint $table) {
            $table->dropColumn('icon');
        });
    }
};
