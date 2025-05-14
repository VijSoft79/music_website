<?php

namespace App\Livewire\Admin\Transaction;

use App\Models\Transaction;
use Livewire\Component;
use Livewire\WithPagination;

class TransactionList extends Component
{
    use WithPagination;

    public $search = '';
    public $dateRange = '';
    public bool $clearDates = false;


    protected $updatesQueryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $transactions = Transaction::with(['user', 'invitation.user'])
            ->when($this->dateRange, function ($query) {
                $dates = explode(' - ', $this->dateRange);
                if (count($dates) === 2) {
                    $start = \Carbon\Carbon::createFromFormat('Y-m-d', $dates[0])->startOfDay();
                    $end = \Carbon\Carbon::createFromFormat('Y-m-d', $dates[1])->endOfDay();

                    $query->whereBetween('created_at', [$start, $end]);
                }
            })
            ->where('status', 'completed')
            ->orderBy('created_at', 'asc')
            ->get();

        //total amount
        $transactionTotal = $transactions->sum('amount');

        return view('livewire.admin.transaction.transaction-list', [
            'transactions' => $transactions,
            'totalAmount' => $transactionTotal,
        ]);
    }

}