<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatNotificationLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'chat_message_id',
        'notified_at'
    ];

    protected $casts = [
        'notified_at' => 'datetime'
    ];

    /**
     * Get the chat message that was notified.
     */
    public function chatMessage(): BelongsTo
    {
        return $this->belongsTo(ChatMessage::class);
    }
}
