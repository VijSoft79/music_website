<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Traits\WithUnsubscribeLink;

class EmailToMusicianWhenWorkIsDone extends Mailable
{
    use Queueable, SerializesModels, WithUnsubscribeLink;

    public $curator;
    public $musician;
    public $offer;

    /**
     * Create a new message instance.
     */
    public function __construct($offer)
    {
        $this->curator = $offer->user;
        $this->musician = $offer->music->artist;
        $this->offer = $offer;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Work Is Done',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.email-to-musician-when-work-is-done',
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
