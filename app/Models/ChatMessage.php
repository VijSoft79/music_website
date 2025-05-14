<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'reciever_id',
        'offer_id',
        'content',
        'status',
    ];

    /**
     * Get the sender of the message.
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Get the reciever of the message.
     */
    public function reciever(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reciever_id');
    }

    /**
     * Get the related offer.
     */
    public function offer(): BelongsTo
    {
        return $this->belongsTo(Offer::class,'offer_id');
    }

    /**
     * Get the notification log for this message.
     */
    public function notificationLog(): HasOne
    {
        return $this->hasOne(ChatNotificationLog::class);
    }

    /**
     * Check if this message has been notified.
     */
    public function hasBeenNotified(): bool
    {
        return $this->notificationLog()->exists();
    }

    /**
     * Get messages without replies within specified hours, grouped by offer.
     */
    public function scopeUnrepliedWithinHours($query, int $hours = 24)
    {
        $thresholdTime = Carbon::now()->subHours($hours);

        return $query->where('created_at', '>=', $thresholdTime)
            ->whereIn('id', function($subquery) {
                $subquery->selectRaw('MAX(id)')
                    ->from('chat_messages as cm')
                    ->groupBy('sender_id', 'reciever_id', 'offer_id');
            })
            ->whereNotExists(function ($query) {
                $query->select('id')
                    ->from('chat_messages as replies')
                    ->whereColumn('replies.sender_id', 'chat_messages.reciever_id')
                    ->whereColumn('replies.reciever_id', 'chat_messages.sender_id')
                    ->whereColumn('replies.offer_id', 'chat_messages.offer_id')
                    ->whereColumn('replies.created_at', '>', 'chat_messages.created_at');
            })
            ->whereDoesntHave('notificationLog'); // Only get messages that haven't been notified
    }

    /**
     * Get the last reply to this message if it exists.
     */
    public function getLastReply()
    {
        return ChatMessage::where('sender_id', $this->reciever_id)
            ->where('reciever_id', $this->sender_id)
            ->where('offer_id', $this->offer_id)
            ->where('created_at', '>', $this->created_at)
            ->latest()
            ->first();
    }

    /**
     * Check if the message has been replied to.
     */
    public function hasReply(): bool
    {
        return $this->getLastReply() !== null;
    }

    /**
     * Log that this message has been notified.
     */
    public function logNotification(): void
    {
        if (!$this->hasBeenNotified()) {
            $this->notificationLog()->create([
                'notified_at' => now()
            ]);
        }
    }
}
