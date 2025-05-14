<?php

namespace App\Http\Controllers\Musician;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index()
    {

        $transactions = Transaction::where("user_id", Auth::user()->id)->get();
        $data = [];

        foreach ($transactions as $transaction) {

            $btnView = '<a href="' . route('musician.transaction.show', $transaction) . '" class="btn btn-xs btn-default text-primary mx-1 shadow">
                <i class="fa fa-lg fa-fw fa-pen"></i>
                </a>';

            $rowData = [
                $transaction->id,
                $transaction->type,
                $transaction->created_at,
                $transaction->status,
                $transaction->amount,
                '<nobr>' . $btnView . '</nobr>',
            ];
            $data[] = $rowData;
        }

        return view( 'musician.transactions.index', [
            'data' => $data
            ]
        );
    }

    public function show(Transaction $transaction)
    {
        return view('musician.transactions.show',compact('transaction'));
    }
}
