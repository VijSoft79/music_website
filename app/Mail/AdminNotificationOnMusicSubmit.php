<?php

namespace App\Mail;

use App\Models\EmailMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Traits\WithUnsubscribeLink;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;

use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdminNotificationOnMusicSubmit extends Mailable
{
    use Queueable, SerializesModels, WithUnsubscribeLink;

    public $user_name;
    public $content;

    /**
     * Create a new message instance.
     */
    public function __construct($user_name)
    {
        $this->user_name = $user_name;

        // Retrieve the email content from the database
        $emailMessage = EmailMessage::where('email_type', 'email to admin for music submission')->first();
        $content = $emailMessage ? $emailMessage->content : '';

        // Variables to replace in the content
        $data = [
            '{user_name}' => $this->user_name,
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
            subject: 'Music Submition',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.admin-notification-on-music-submit',
            with: ['content' => $this->content]
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
