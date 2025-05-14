<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;
use App\Traits\WithUnsubscribeLink;

class ReportMusic extends Mailable
{
    use Queueable, SerializesModels, WithUnsubscribeLink;

    /**
     * Create a new message instance.
     */
    public $content;
    public $musicTitle;
    public $userRole;
    public $userEmail;

    public function __construct($userRole, $musicTitle, $content, $userEmail)
    {
        $this->userRole = $userRole;
        $this->musicTitle = $musicTitle;
        $this->content = $content;
        $this->userEmail = $userEmail;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address($this->userEmail),
            subject: 'Music Report'. '('."$this->musicTitle".')',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.report-music',
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
