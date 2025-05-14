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

class MusicPaymentSuccess extends Mailable
{
    use Queueable, SerializesModels, WithUnsubscribeLink;

    public $musicTitle;
    public $musicArtist;
    public $content;

    /**
     * Create a new message instance.
     */
    public function __construct($music)
    {
        $this->musicTitle = $music->title;
        $this->musicArtist = $music->artist->name;

        // Retrieve the email content from the database
        $emailMessage = EmailMessage::where('email_type', 'email to admin for music payment success')->first();
        $content = $emailMessage ? $emailMessage->content : '';

        $data = [
            '{musicTitle}' => $this->musicTitle,
            '{musicArtist}' => $this->musicArtist,
        ];

        // Replace placeholders with actual data
        foreach ($data as $placeholder => $value) {
            $content = str_replace($placeholder, $value, $content);
        }

        $this->content = $content;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Music Payment Success: ' . $this->musicTitle,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.music-payment-sucessfull',
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
