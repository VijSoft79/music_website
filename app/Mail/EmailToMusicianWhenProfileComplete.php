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

class EmailToMusicianWhenProfileComplete extends Mailable
{
    use Queueable, SerializesModels, WithUnsubscribeLink;

    public $musician;

    public $content;

    /**
     * Create a new message instance.
     */
    public function __construct($musician)
    {
        $this->musician = $musician->name;

        $emailMessage = EmailMessage::where('email_type', 'to musician when profile complete')->first();
        $content = $emailMessage ? $emailMessage->content : '';

        $this->content = $content;

    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Profile Complete!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.email-to-musician-when-profile-complete',
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
