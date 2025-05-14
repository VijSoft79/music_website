<?php

namespace App\Livewire\Musician;

use App\Models\Offer;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class InvitationList extends Component
{
    public $status;

    public function mount($status)
    {
        $this->status = $status;
        // dd($this->status);
    }

    public function getInvitations()
    {
        return Offer::whereHas('music', function ($query) {
            $query->where('user_id', Auth::id())
                ->whereNull('deleted_at');
        })
            ->where('status', $this->status)

            // status == 0
            ->when($this->status == 0, function ($query) {
                $query->where('expires_at', '>', Carbon::now());
            })

            // filter if status != 2
            ->when($this->status != 2, function ($query) {
                $query->doesntHave('report');
            })

            ->orderBy('date_complete', 'desc')
            ->get();
    }

    public function render()
    {
        return view(
            'livewire.musician.invitation-list',
            [
                'offers' => $this->getInvitations(),
            ]
        );
    }
}
