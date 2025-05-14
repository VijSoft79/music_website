<?php

namespace App\Livewire\Curator;

use App\Models\Offer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class OffersList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $status;

    public function mount($status)
    {
        $this->status = $status;
    }

    public function getOffersProperty()
    {
        return Offer::where('user_id', Auth::id())
            ->where('status', $this->status)
            ->whereHas('music', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->when($this->status != 2, function ($query) {
                $query->doesntHave('report');
            })
            ->orderBy('date_complete', 'desc')
            ->paginate(15);
    }

    public function getLateOffersProperty()
    {
        if ($this->status !== 1) {
            return collect();
        }
        
        return Offer::getLateInvitations();
    }
    
    public function getActiveOffersProperty()
    {
        if ($this->status !== 1) {
            return collect();
        }
        
        return Offer::getActiveInvitations();
    }

    public function render()
    {
        return view('livewire.curator.offers-list', [
            'offers' => $this->status == 1 ? collect() : $this->offers,
            'lateOffers' => $this->lateOffers,
            'activeOffers' => $this->activeOffers,
            'hasLateInvitations' => Offer::hasLateInvitations()
        ]);
    }
}
