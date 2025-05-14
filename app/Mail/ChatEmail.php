<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Traits\WithUnsubscribeLink;

use App\Models\Offer;
use App\Models\User;

class ChatEmail extends Mailable
{
    use Queueable, SerializesModels, WithUnsubscribeLink;

    /**
     * Create a new message instance.
     */
    public $sender;
    public $reciever;
    public $offer;
    
    public function __construct($data)
    {
        
        $this->sender = $data['sender'];
        $this->reciever = User::find($data['reciever']['id']);
        $this->offer = Offer::find($data['offer_id']);
        
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'You have new unread message',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.unread-chat-notification',
            with: [
                'sender' => $this->sender,
                'reciever' => $this->reciever,
                'offer' => $this->offer,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
