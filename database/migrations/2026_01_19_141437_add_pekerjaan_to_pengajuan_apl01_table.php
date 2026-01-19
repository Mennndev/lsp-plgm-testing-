<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengajuan_apl01', function (Blueprint $table) {
            $table->string('pekerjaan')->nullable()->after('kualifikasi_pendidikan');
        });
    }

    public function down(): void
    {
        Schema::table('pengajuan_apl01', function (Blueprint $table) {
            $table->dropColumn('pekerjaan');
        });
    }
};
