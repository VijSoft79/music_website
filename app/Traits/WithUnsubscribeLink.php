<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Crypt;

trait WithUnsubscribeLink
{
    /**
     * The user who will receive the email
     *
     * @var User|null
     */
    protected $user;

    /**
     * Add the unsubscribe URL to the email data
     *
     * @return $this
     */
    protected function withUnsubscribeLink()
    {
        if ($this->user) {
            $unsubscribeUrl = URL::signedRoute('email.unsubscribe', ['user' => Crypt::encrypt($this->user->id)]);
            $this->viewData['unsubscribe_url'] = $unsubscribeUrl;
        }
        
        return $this;
    }

    /**
     * Set the user for this email
     *
     * @param User $user
     * @return $this
     */
    public function forUser(User $user)
    {
        $this->user = $user;
        return $this->withUnsubscribeLink();
    }

    /**
     * Build the message.
     * 
     * This is called when the message is sent, allowing a last chance
     * to customize the message before it's sent.
     *
     * @return $this
     */
    public function build()
    {
        return $this->withUnsubscribeLink();
    }
} 