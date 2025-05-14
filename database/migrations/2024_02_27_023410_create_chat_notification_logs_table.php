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
        Schema::create('chat_notification_logs', function (Blueprint $table) {
            if (!Schema::hasTable('chat_notification_logs')) {
                $table->id();
                $table->foreignId('chat_message_id')->constrained('chat_messages')->onDelete('cascade');
                $table->timestamp('notified_at');
                $table->timestamps();

                // Add unique constraint to prevent duplicate notifications
                $table->unique('chat_message_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_notification_logs');
    }
};
