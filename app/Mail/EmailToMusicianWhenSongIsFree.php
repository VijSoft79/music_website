<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

use App\Models\EmailMessage;
use App\Traits\WithUnsubscribeLink;

class EmailToMusicianWhenSongIsFree extends Mailable
{
    use Queueable, SerializesModels, WithUnsubscribeLink;
    public $content;
    /**
     * Create a new message instance.
     */
    public function __construct()
    {
        $emailMessage = EmailMessage::where('email_type', 'email to musician when song is free')->first();
        $content = $emailMessage ? $emailMessage->content : '';

        $this->content = $content;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Music is Now Available for Free on You Hear Us!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.email-to-musician-when-song-is-free',
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
