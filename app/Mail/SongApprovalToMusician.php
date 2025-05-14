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

class SongApprovalToMusician extends Mailable
{
    use Queueable, SerializesModels, WithUnsubscribeLink;

    public $music;
    public $artist;
    public $title;
    public $content;

    /**
     * Create a new message instance.
     */
    public function __construct($music)
    {
        $this->music = $music;
        $this->artist = $music->artist->name;
        $this->title = $music->title;

        // Retrieve the email content from the database
        $emailMessage = EmailMessage::where('email_type', 'email to musician for music approval/payment')->first();
        $content = $emailMessage ? $emailMessage->content : '';

        $data = [
            '{title}' => $this->title,
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
            subject: 'Song Approval',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.song-approval-to-musician',
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
