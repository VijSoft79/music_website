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

class EmailToCuratorWorkApproved extends Mailable
{
    use Queueable, SerializesModels, WithUnsubscribeLink;

    public $content;
    public $curator;
    public $amount;

    /**
     * Create a new message instance.
     */
    public function __construct($curator, $amount)
    {
        $this->curator = $curator->name;
        $this->amount = $amount;

        // add email type
        $emailMessage = EmailMessage::where('email_type', 'email to curator when work is approved')->first();
        $content = $emailMessage ? $emailMessage->content : '';

        $data = [
            '{curator}' => $this->curator,
            '{amount}' => $this->amount,
        ];

         // Replace placeholders with actual data
         
         foreach ($data as $placeholder => $value) {
            $content = str_replace($placeholder, $value, $content);
        }
        $this->content = $content;
        // dd($this->content);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Worked has been Approved',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.email-to-curator-work-approve',
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
