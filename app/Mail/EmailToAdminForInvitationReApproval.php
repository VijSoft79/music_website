<?php

namespace App\Mail;

use App\Models\OfferTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Traits\WithUnsubscribeLink;


class EmailToAdminForInvitationReApproval extends Mailable
{
    use Queueable, SerializesModels, WithUnsubscribeLink;

    public $offerTemplate;

    public $curator;

    /**
     * Create a new message instance.
     */
    public function __construct($offerTemplate)
    {
        $this->offerTemplate = $offerTemplate;
        $this->curator = $offerTemplate->curator;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invitation Re Approval',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.email-to-admin-for-invitation-re-approval',
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
