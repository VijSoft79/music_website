<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;

class AllowedEmbedDomain implements Rule
{
    protected $allowedDomains = [
        'youtube.com',
        'vimeo.com',
        'bandcamp.com',
        'open.spotify.com',
        'soundcloud.com',
    ];

    public function passes($attribute, $value)
    {
        // Regular expression pattern to match any of the allowed domains, handling both subdomains and URL encoding
        $pattern = '/src="https?:\/\/(?:w{0,3}\.)?(?:' . implode('|', array_map('preg_quote', $this->allowedDomains)) . ')(?:\/|%2F)/i';

        // Check if the value matches the pattern
        return preg_match($pattern, $value);
    }

    public function message()
    {
        return 'The :attribute must be a valid embed code from an allowed domain.';
    }
}
