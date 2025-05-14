<?php

namespace App\View\Components\Musician\Invitation;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class OfferCard extends Component
{
    public $offer;
    public $template;

    public $type;
    /**
     * Create a new component instance.
     */
    public function __construct($offer, $template , $type)
    {
        $this->offer = $offer;
        $this->template = $template;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.musician.invitation.offer-card');
    }
}
