<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Traits\WithUnsubscribeLink;


use App\Models\EmailMessage;

class EmailToAdminCompleteWorkSubmited extends Mailable
{
    use Queueable, SerializesModels, WithUnsubscribeLink;

    public $curator;

    /**
     * Create a new message instance.
     */
    public function __construct($offer)
    {
        // add email type
        // $emailMessage = EmailMessage::where('email_type', 'email to admin for work submition')->first();
        // $content = $emailMessage ? $emailMessage->content : '';

        $this->curator = $offer->user->name;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'A Curator submited A Wok',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.email-to-admin-complete-work-submit',
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
