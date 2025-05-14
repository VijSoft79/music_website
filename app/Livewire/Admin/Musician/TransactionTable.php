<?php

namespace App\Livewire\Admin\Musician;

use Livewire\Component;

class TransactionTable extends Component
{
    public $user;
    public $transactions = [];
    public $transactionType;

    public $title;
    public  $tableNumber;

    public function render()
    {
        $transactions = $this->user->transactions()->where('type', $this->transactionType)->get();
        foreach ($transactions as $transaction) {
            $rowData = [
                $transaction->type,
                $transaction->status,
                $transaction->amount,
                $transaction->created_at,
            ];

            $this->transactions[] = $rowData;
        }
        
        return view('livewire.admin.musician.transaction-table');
    }
}
