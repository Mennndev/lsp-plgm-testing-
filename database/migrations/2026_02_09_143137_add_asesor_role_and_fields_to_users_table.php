<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, add new columns
        Schema::table('users', function (Blueprint $table) {
            $table->text('alamat')->nullable()->after('no_hp');
            $table->boolean('status_aktif')->default(true)->after('alamat');
        });
        
        // Then, modify the role enum to include 'asesor'
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('user', 'admin', 'asesor') DEFAULT 'user'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['alamat', 'status_aktif']);
        });
        
        // Revert role enum back to original values
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('user', 'admin') DEFAULT 'user'");
    }
};
