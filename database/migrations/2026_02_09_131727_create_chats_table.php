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
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('admin_id')->unsigned()->nullable();
            $table->string('subject')->nullable();
            $table->enum('status', ['open', 'closed', 'waiting'])->default('waiting');
            $table->text('last_message')->nullable();
            $table->bigInteger('last_message_by')->unsigned()->nullable();
            $table->timestamp('last_message_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('last_message_by')->references('id')->on('users')->onDelete('set null');
            $table->index(['status', 'created_at']);
        });

        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('chat_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->text('message');
            $table->string('attachment')->nullable();
            $table->timestamps();

            $table->foreign('chat_id')->references('id')->on('chats')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['chat_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
        Schema::dropIfExists('chats');
    }
};
