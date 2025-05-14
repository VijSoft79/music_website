<?php

namespace App\Livewire;

use App\Models\ChatMessage;
use App\Models\Offer;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChatBox extends Component
{
    public Offer $offer;
    public $messages;
    public $content = '';

    public $receiverId;

    protected $listeners = ['messageSent' => 'loadMessages'];

    public function mount(Offer $offer)
    {
        $this->offer = $offer;
        $this->loadMessages();

        //get reciever id
        $this->receiverId = auth()->user()->hasRole('curator')
            ? $this->offer->music->artist->id
            : $this->offer->user_id;

        // Mark all previous messages from the receiver as "read" once visit the chat
        if ($this->offer && $this->offer->exists) {
            ChatMessage::where('sender_id', $this->receiverId )
                ->where('reciever_id', auth()->id())
                ->where('offer_id', $this->offer->id)
                ->update(['status' => 'read']);
        }
    }

    //load get messages based on offer
    public function loadMessages()
    {
        if (!$this->offer || !$this->offer->exists) {
             $this->messages = collect();
             return;
         }
        $this->messages = ChatMessage::where('offer_id', $this->offer->id)
            ->orderBy('created_at')
            ->get();
    }

    public function sendMessage()
    {
        if (!$this->offer || !$this->offer->exists) {
            $this->addError('content', 'Cannot send message, the offer is no longer available.');
            return;
        }

        // Only proceed if message is not empty
        if (trim($this->content) != "") {

            // Create the new message
            ChatMessage::create([
                'sender_id' => auth()->id(),
                'reciever_id' => $this->receiverId ,
                'content' => $this->content,
                'offer_id' => $this->offer->id,
                'status' => 'unread', // assuming you want the receiver to see it as unread
            ]);
        }

        $this->content = '';
        $this->loadMessages();
    }


    public function render()
    {
        // Explicitly check if the offer exists in the database by fetching it again
        $freshOffer = Offer::find($this->offer->id);

        if (!$freshOffer) {
            // Offer not found in DB (likely deleted), render the placeholder view
            return view('livewire.null-view');
        }

        // Offer exists, proceed with normal rendering
        return view('livewire.chat-box');
    }
}
