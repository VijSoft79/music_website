<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class VerifyUser extends Component
{
    public $userId;
    /**
     * Create a new component instance.
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.verify-user');
    }
}
