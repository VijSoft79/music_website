<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Traits\WithUnsubscribeLink;
class DynamicMailer extends Mailable
{
    use Queueable, SerializesModels, WithUnsubscribeLink;

    public $mailTo;
    public $subject;
    public $content;

    /**
     * Create a new message instance.
     */
    public function __construct($mailTo, $subject, $content)
    {
        $this->mailTo = $mailTo;
        $this->subject = $subject;
        $this->content =  $content;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Dynamic Mailer',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.dynamic-mail',
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
