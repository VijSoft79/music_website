<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

use App\Models\Offer;
use App\Models\BasicOffer;
use App\Models\PremiumOffer;
use App\Models\CuratorWallet;
use App\Models\FreeAlternative;

class CuratorWalletController extends Controller
{
    public function index()
    {
        
        $user = Auth::user();
        $wallet = CuratorWallet::where('curator_id', Auth::user()->id)->first();
        $data = $this->gettransactionList($user);
 
        return view('curator.wallet.index', [
            'data' => $data,
            'wallet' => $wallet,
        ]);
    }

    public function show(Transaction $transaction)
    {
        
        return view('curator.wallet.show', [
            'transaction' => $transaction,
        ]);
    }
    
    public static function getTemplate($offer = null)
    {
        $invitation = Offer::where('id', $offer)->first();

        switch ($invitation->offer_type) {
            case 'premium':
                $template = PremiumOffer::where('id', $invitation->offer_type_id)->first();
                break;
            case 'free-option':
                $template = FreeAlternative::where('id', $invitation->offer_type_id)->first();
                break;
            default:
                $template = BasicOffer::where('id', $invitation->offer_type_id)->first();
        }

        return $template;
    }

    public function gettransactionList($user)
    {

        $transactions = Transaction::where('user_id',  $user->id)->get();
        $data = [];
        foreach ($transactions as $transaction) {
            $btnDetails = '<a href="'. route('curator.wallet.show', $transaction ) .'" class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                    <i class="fa fa-lg fa-fw fa-eye"></i>
                </a>';

            $rowData = [
                $transaction->id,
                $transaction->type,
                $transaction->created_at,
                $transaction->amount,
                $transaction->status,
                '<nobr>' . $btnDetails . '</nobr>',
            ];
            $data[] = $rowData;
        }

        return $data;
    }

   
}
