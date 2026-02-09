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
        Schema::table('pembayaran', function (Blueprint $table) {
            // Drop existing column if it exists
            if (Schema::hasColumn('pembayaran', 'verifier_id')) {
                $table->dropColumn('verifier_id');
            }
            // Add correct column type
            $table->bigInteger('verifier_id')->unsigned()->nullable()->after('user_id');
            $table->foreign('verifier_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembayaran', function (Blueprint $table) {
            $table->dropForeign(['verifier_id']);
            $table->dropColumn('verifier_id');
        });
    }
};
