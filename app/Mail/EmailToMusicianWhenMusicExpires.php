<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Traits\WithUnsubscribeLink;

class EmailToMusicianWhenMusicExpires extends Mailable
{
    use Queueable, SerializesModels, WithUnsubscribeLink;

    /**
     * Create a new message instance.
     */
    public $artist;
    public $musicTitle;
    public function __construct($artist, $musicTitle)
    {
        $this->artist = $artist;
        $this->musicTitle = $musicTitle;

    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Music Expiration',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.email-to-musician-when-music-expires',
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
