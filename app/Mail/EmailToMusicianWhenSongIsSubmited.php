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

class EmailToMusicianWhenSongIsSubmited extends Mailable
{
    use Queueable, SerializesModels, WithUnsubscribeLink;

    public $content;

    /**
     * Create a new message instance.
     */
    public function __construct()
    {
        // Retrieve the email content from the database
        $emailMessage = EmailMessage::where('email_type', 'email to musician for music submit')->first();
        $content = $emailMessage ? $emailMessage->content : '';

        $this->content = $content;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Thank You For Submitting',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.email-to-musician-when-music-submited',
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
