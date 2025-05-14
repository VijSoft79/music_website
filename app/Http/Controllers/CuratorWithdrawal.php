<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Transaction;

class CuratorWithdrawal extends Controller
{
    public function withdrawRequest(Request $request){
        $user = User::find($request)->first();
       
        // Email curator for request

        // check if a pending request is available 
        $pendingTransaction = Transaction::where('user_id', $user->id)
        ->where('status', 'pending')
        ->where('type', 'withdrawal-request')
        ->first();

        if($pendingTransaction){
            return response()->json([
                'message' => 'You Still have a pending request. rest assured while we are procesing your request. '
            ], 200);
        }

        // Save Withdraw request to transaction table
        $transaction = new Transaction;
        $transaction->user_id = $user->id;
        $transaction->amount = $user->wallet->amount;
        $transaction->type = 'withdrawal-request';
        $transaction->status = 'pending';
        $transaction->save();

        // return curator to wallet index
        // return response()->json($user);
        return response()->json([
            'message' => 'Requested amount has been sent to the admin.'
        ], 200);
    }
    
}
