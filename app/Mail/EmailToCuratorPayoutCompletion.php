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
class EmailToCuratorPayoutCompletion extends Mailable
{
    use Queueable, SerializesModels, WithUnsubscribeLink;

    public $content;

    /**
     * Create a new message instance.
     */
    public function __construct()
    {
        $content = EmailMessage::where('email_type', 'email to curator when payout successful')->first();
        $this->content = $content->content ;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Payout Complete',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.email-to-curator-when-payout-success',
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
