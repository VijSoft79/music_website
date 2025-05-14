<?php

namespace App\Mail;

use App\Traits\WithUnsubscribeLink;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;


class ContactHelp extends Mailable
{
    use Queueable, SerializesModels, WithUnsubscribeLink;

    /**
     * Create a new message instance.
     */
    public $email;
    public $subject;
    public $content;
    public $userRole;

    public function __construct($email, $subject, $content, $userRole)
    {
        //
        $this->email = $email;
        $this->subject = $subject;
        $this->content = $content;
        $this->userRole = $userRole;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        
        return new Envelope(
            from: new address($this->email),
            subject: $this->subject . '('.$this->userRole.')',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // dd($this->message);
        return new Content(
            view: 'emails.contact-help-mail',
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
