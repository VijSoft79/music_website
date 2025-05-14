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

class RegistrationNotifToadmin extends Mailable
{
    use Queueable, SerializesModels, WithUnsubscribeLink;

    public $email;
    public $name;

    /**
     * Create a new message instance.
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject:  $this->name . ' regitered to youhear us',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $emailcontent = EmailMessage::where('email_type', 'registration notif')->get();
        $this->email = $emailcontent[0]->content;
        
        return new Content(
            view: 'emails.register-notification-to-admin',
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
