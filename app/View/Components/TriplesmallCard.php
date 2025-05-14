<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TriplesmallCard extends Component
{
    /**
     * Create a new component instance.
     */
    public $title1;
    public $icon1;
    public $url1;

    public $title2;
    public $icon2;
    public $url2;

    public $title3;
    public $icon3;
    public $url3;



    public function __construct($title1, $title2, $title3, $icon1, $icon2, $icon3, $url1, $url2, $url3)
    {
        $this->title1 = $title1;
        $this->title2 = $title2;
        $this->title3 = $title3;

        $this->icon1 = $icon1;
        $this->icon2 = $icon2;
        $this->icon3 = $icon3;

        $this->url1 = $url1;
        $this->url2 = $url2;
        $this->url3 = $url3;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.triplesmall-card');
    }
}
