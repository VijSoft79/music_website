<?php

namespace App\Livewire;

use App\Models\ChatMessage;
use Livewire\Component;

class ChatInbox extends Component
{

    public function render()
    {
        $userId = auth()->id();
        $userId = auth()->id();

        $chats = ChatMessage::with('offer')
            ->where('reciever_id', $userId)
            ->whereHas('offer.music')
            ->orderBy('created_at', 'desc')
            ->get();
    
        // Sort chats so that 'unread' messages come first
        $sortedChats = $chats->sortBy(function ($chat) {
            return $chat->status === 'unread' ? 0 : 1;
        });
    
        // Then group by offer_id
        $chatMessages = $sortedChats->groupBy('offer_id');

        return view('livewire.chat-inbox', [
            'chats' => $chatMessages,
        ]);
    }
}
