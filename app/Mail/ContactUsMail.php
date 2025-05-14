<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Traits\WithUnsubscribeLink;


use Illuminate\Support\Facades\Auth;

class ContactUsMail extends Mailable
{
    use Queueable, SerializesModels, WithUnsubscribeLink;

    public $name;
    public $email;
    public $content;
    public $title;

    /**
     * Create a new message instance.
     */
    public function __construct($name, $email, $content)
    {
        $this->name = $name;
        $this->email = $email;
        $this->content = $content;


    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address($this->email , $this->name),
            subject: 'Contact Us Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-us-mail',
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
