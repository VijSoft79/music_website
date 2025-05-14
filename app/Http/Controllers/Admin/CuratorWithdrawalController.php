<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Transaction;
use App\Models\CuratorWallet;

use Illuminate\Support\Facades\Mail;
use App\Mail\EmailToCuratorPayoutCompletion;

use App\Services\EmailService;

// use App\Services\EmailPreferenceService;

class CuratorWithdrawalController extends Controller
{

    // protected $emailPreferenceService;
    // public function __construct(EmailPreferenceService $emailPreferenceService)
    // {
    //     $this->emailPreferenceService = $emailPreferenceService;
    // }

    protected $emailService;

    public function __construct()
    {
        $this->emailService = app(EmailService::class);
    }

    public function index()
    {
        // Fetch all transactions that are withdrawal requests AND are pending
        $pendingTransactions = Transaction::where('type', 'withdrawal-request')
            ->where('status', 'pending')
            ->whereNull('deleted_at')
            ->orderBy('created_at') // Keep ordering by date
            ->get(); // Get all matching transactions

        $data = [];
        // Loop directly through the pending transactions
        foreach ($pendingTransactions as $transaction) {
            // No need to check status again, the query already filtered for 'pending'
            $btnDetails = '<a href="' . route('widthrawal.show', $transaction) . '" class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details" >	
    <i class="fa fa-lg fa-fw fa-eye"></i>	
    </a>';

            $rowData = [
                $transaction->id,
                $transaction->user->name,
                'Pending', // Status is known to be pending
                $transaction->created_at,
                $transaction->amount,
                '<nobr>' . $btnDetails . '</nobr>',
            ];
            $data[] = $rowData;
        }

        return view('admin.withdraw-requests.index', [
            'data' => $data
        ]);
    }

    public function show(Transaction $transaction)
    {
        return view('admin.withdraw-requests.show', [
            'request' => $transaction,
        ]);
    }

    public function update(Transaction $transaction)
    {
        $this->approveRequest($transaction);
        $this->updateCuratorWallet($transaction);
        return redirect()->route('widthrawal.index')->with('message', 'Request Has Been Approve');
    }

    public function approveRequest($transaction)
    {
        Transaction::create([
            'user_id' => $transaction->user_id,
            'amount' => -abs($transaction->amount),
            'type' => 'withdrawal-request',
            'status' => 'completed'
        ]);

        $this->emailService->send($transaction->user->email, (new EmailToCuratorPayoutCompletion())->forUser($transaction->user), 'curator.payout.completion', $transaction->user);
    }

    public function updateCuratorWallet($transaction)
    {
        $curatorsWallet = CuratorWallet::where('curator_id', $transaction->user_id)->first();
        $curatorsWallet->amount = 0;
        $curatorsWallet->save();
    }
}
