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

class EmailToArtistRegister extends Mailable
{
    use Queueable, SerializesModels, WithUnsubscribeLink;

    public $content;
    
    public $name;

    // public $email;


    /**
     * Create a new message instance.
     */
    public function __construct($name)
    {
        // $this->url = $url;
        $this->name = $name;
        
        // Retrieve the email content from the database
        $emailMessage = EmailMessage::where('email_type', 'email to musician for registration')->first();
        $content = $emailMessage ? $emailMessage->content : '';
        $this->content = $content;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Thank You',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.register-notification-to-artist',
            // with: ['content' => $this->content]
        );
    }

    /**
     * Build the message.
     */
    // public function build()
    // {
    //     return $this->to($this->email) // Set the recipient email
    //         ->view('emails.register-notification-to-artist')
    //         ->subject('Verify Your Email Address')
    //         ->with([
    //             'url' => $this->url,
    //             'content' => $this->content,
    //         ]);
    // }

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
