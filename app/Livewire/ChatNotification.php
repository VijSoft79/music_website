<?php

namespace App\Livewire;

use App\Models\ChatMessage;
use Livewire\Component;

class ChatNotification extends Component
{
    public function render()
    {
        $userId = auth()->id();

        //get unread chats with music in offer
        $unreadOffers = ChatMessage::with('offer')
            ->where('reciever_id', $userId)
            ->where('status', 'unread')
            ->whereHas('offer.music')
            ->orderBy('created_at', 'desc')
            ->get();


        $groupUnread = $unreadOffers->groupBy('offer_id')->take(5);


        return view('livewire.chat-notification', [
            'groupUnread' => $groupUnread,
            'count' => $unreadOffers->count(),
        ]);
    }
}
