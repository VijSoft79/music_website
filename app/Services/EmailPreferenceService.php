<?php

namespace App\Services;

use App\Models\User;

class EmailPreferenceService
{
    public function userWantsEmail(User $user, int $emailId): bool
    {
        // dd($user->chosenEmails);
        // Assuming you have a relationship between User and EmailPreferences
        // return $user->emailPreferences()->where('email_type', $emailType)->exists();

        
        $id = [];
        foreach ($user->chosenEmails as $chosenEmail) {
            $emailMessages = $chosenEmail->email_messages;
            foreach ($emailMessages as $emailMessage) {
                // Process the email message
                $id[] = $emailMessage->id; // Example output
            }
        }

        if(in_array($emailId, $id)){
            return true;
        }
        
        return true;
    }
}