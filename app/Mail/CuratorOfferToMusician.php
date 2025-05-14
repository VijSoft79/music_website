<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Traits\WithUnsubscribeLink;


class CuratorOfferToMusician extends Mailable
{
    use Queueable, SerializesModels, WithUnsubscribeLink;

    public $basicTitle = "";

    public $premiumTitle = "";
    public $premiumContent = "";

    public $musicTitle = "";
    public $invitation = "";
    /**
     * Create a new message instance.
     */
    public function __construct($invitation, $basicTitle, $musicTitle, $premiumTitle = null, $premiumContent = null)
    {
        $this->basicTitle = $basicTitle;
        $this->premiumTitle = $premiumTitle;
        $this->premiumContent = $premiumContent;
        $this->musicTitle = $musicTitle;
        $this->invitation = $invitation;
        
        // add email type  
        // $emailMessage = $intro;
        // $message = $emailMessage ? $emailMessage->content : '';

        // $data = [
        //     '[musicianname]' => $this->$invitation->artist->name,
        // ];

        // // Replace placeholders with actual data
        // foreach ($data as $placeholder => $value) {
        //     $content = str_replace($placeholder, $value, $emailMessage);
        // }

        // $this->intro = $content;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        // Get curator name, handle potential null values
        $curatorName = $this->invitation?->user?->name ?? 'A Curator';

        return new Envelope(
            subject: $curatorName . ' sent you a new offer on your song: ' . $this->musicTitle,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.curators-offer-mail',
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
