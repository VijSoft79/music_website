<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Crypt;

class EmailService
{
    // Critical email types that should always be sent regardless of preferences
    protected $criticalEmailTypes = [
        'password.reset',
        'email.verification'
    ];

    // Send an email if the user has not opted out of receiving emails
    public function send($recipients, Mailable $mailable, string $emailType, ?User $user = null)
    {
        // For critical emails, always send them
        if (in_array($emailType, $this->criticalEmailTypes)) {
            Mail::to($recipients)->send($mailable);
            return true;
        }

        // If we have a user and they've opted out, don't send
        if ($user && !$this->userWantsEmail($user)) {
            return false;
        }

        // Generate unsubscribe link
        if ($user) {
            $unsubscribeUrl = $this->generateUnsubscribeUrl($user);
            $mailable->with(['unsubscribe_url' => $unsubscribeUrl]);
        }

        Mail::to($recipients)->send($mailable);
        return true;
    }

    /**
     * Check if a user wants to receive non-critical emails
     * 
     * @param User $user
     * @return bool
     */
    protected function userWantsEmail(User $user): bool
    {
        return $user->is_email_enabled ?? false;
    }

    /**
     * Generate a signed URL for unsubscribing from emails
     * 
     * @param User $user
     * @return string
     */
    protected function generateUnsubscribeUrl(User $user): string
    {
        return URL::signedRoute('email.unsubscribe', ['user' => Crypt::encrypt($user->id)]);
    }
} 