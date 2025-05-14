<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::where('type','invitation-payment')->get()->groupBy('offer_id')->sortByDesc('created_at')->first();
        // dd($transactions);
        foreach ($transactions as $transaction) {

            $btnShow = '<a href="' . route('admin.music.show', $transaction) . '" class="btn btn-xs btn-default text-primary mx-1 shadow">
                <i class="fa fa-lg fa-fw fa-eye"></i>
                </a>';

            $rowData = [
                $transaction->id,
                $transaction->user->email,
                $transaction->type,
                $transaction->amount,
                $transaction->status,
                '<nobr>' . $btnShow . '</nobr>',
            ];
            $data[] = $rowData;

        }
        return view('admin.transactions.index', [
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
