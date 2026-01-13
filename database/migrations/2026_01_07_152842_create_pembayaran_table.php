<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pengajuan_skema_id')->unsigned();
            $table->integer('user_id');
            $table->string('order_id')->unique(); // ID unik untuk Midtrans
            $table->decimal('nominal', 12, 2);
            $table->string('metode_pembayaran')->nullable(); // bank_transfer, gopay, dll
            $table->string('payment_type')->nullable(); // Tipe dari Midtrans
            $table->string('transaction_id')->nullable(); // Transaction ID dari Midtrans
            $table->string('transaction_status')->nullable(); // Status dari Midtrans
            $table->string('snap_token')->nullable(); // Snap Token untuk popup
            $table->string('pdf_url')->nullable(); // URL PDF instruksi pembayaran
            $table->json('payment_details')->nullable(); // Detail pembayaran (VA number, dll)
            $table->enum('status', ['pending', 'processing', 'success', 'failed', 'expired', 'refunded'])->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->foreign('pengajuan_skema_id')->references('id')->on('pengajuan_skema')->onDelete('cascade');
            $table->index(['user_id', 'status']);
            $table->index('order_id');
            $table->index('transaction_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
