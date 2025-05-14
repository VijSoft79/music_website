<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

use App\Models\BasicOffer;
use App\Models\PremiumOffer;
use App\Models\FreeAlternative;
use App\Models\SpotifyPlaylist;
use App\Traits\WithUnsubscribeLink;


class EmailToCuratorForInvitationPaid extends Mailable
{
    use Queueable, SerializesModels, WithUnsubscribeLink;

    public $musician;
    public $curator;
    public $offer;
    public $template;

    /**
     * Create a new message instance.
     */
    public function __construct($offer)
    {
        // dd($offer);
        
        $this->curator = $offer->user;
        $this->musician = $offer->music->artist;
        $this->offer = $offer;
        // dd($offer->offer_type_id);
        switch ($offer->offer_type) {
            case "standard":
                $template = BasicOffer::where('id', $offer->offer_type_id)->first();
            break;

            case "premium":
                $template = PremiumOffer::where('id', $offer->offer_type_id)->first();
            break;

            case "free-option":
                $template = FreeAlternative::where('id', $offer->offer_type_id)->first();
            break;
                
            default:
            $template = SpotifyPlaylist::where('id', $offer->offer_type_id)->first();
        };
        
        
         // Debug the result

        $this->template = $template;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
       
        $subject = 'Confirmation of Payment';
    
      
        if ($this->offer->offer_type === 'free-option') {
            $subject = "{$this->offer->music->artist->name} Accepted Your Free Offer";
        }
        elseif ($this->offer->offer_type === 'standard') {
            $this->template->offer_price == 0 ? $subject = "{$this->offer->music->artist->name} Accepted Your Free Offer" : $subject;
        }
        elseif ($this->offer->offer_type === 'premium') {
            $this->template->offer_price == 0 ? $subject = "{$this->offer->music->artist->name} Accepted Your Free Offer" : $subject;
        }
        
    
        return new Envelope(
            subject: $subject,
        );
    }
    

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.email-to-curator-for-invitaion-paid',
            with: [
                'musician' => $this->musician,
                'curator' => $this->curator,
                'offer' => $this->offer,
                'template' => $this->template,
            ]
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
