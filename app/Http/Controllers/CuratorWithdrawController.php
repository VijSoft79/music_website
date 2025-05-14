<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;

use Illuminate\Http\Request;
use App\Models\CuratorPaypal;
use App\Services\EmailService;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailToAdminPayoutRequest;
use App\Mail\EmailToCuratorPayoutRequest;

class CuratorWithdrawController extends Controller
{
    protected $emailService;

    public function __construct()
    {
        $this->emailService = app(EmailService::class);
    }

    public function withdrawRequest(Request $request)
    {
        $user = Auth::user();
       
        // Validate wallet exists and has amount
        if (!$user->wallet || !isset($user->wallet->amount)) {
             // Consider logging this error
             Log::warning("User {$user->id} attempted withdrawal with missing wallet info.");
             return redirect()->route('curator.wallet')->with('error', 'Wallet information is missing or invalid. Cannot request payout.');
        }

        // Save/update paypal address first
        try {
            $this->getPaypal($user->id, $request->email);
        } catch (\Exception $e) {
            // Log the error
            Log::error("Error saving PayPal address for user {$user->id} during withdrawal request: " . $e->getMessage());
            return redirect()->route('curator.wallet')->with('error', 'There was an issue saving your PayPal address. Please try again.');
        }

        // Simplified check for an existing PENDING request for THIS user
        $existingPendingTransaction = Transaction::where('user_id', $user->id)
            ->where('type', 'withdrawal-request')
            ->where('status', 'pending')
            ->exists(); // Use exists() for efficiency
        if ($existingPendingTransaction) {
            // User already has a pending request, redirect back.
            return redirect()->route('curator.wallet')->with(
                'message', // Using 'message' for consistency with previous flashed messages
                'You still have a pending request. Rest assured while we are processing your request.'
            );
        }

        // If no pending request exists, proceed to create the new one.
        try {
            $transaction = new Transaction;
            $transaction->user_id = $user->id;
            $transaction->amount = $user->wallet->amount; // Already checked wallet exists above
            $transaction->type = 'withdrawal-request';
            $transaction->status = 'pending';
            $transaction->save(); // Attempt to save

            // Send email notification AFTER successful save
            // Ensure the admin email is correctly configured, using a default for now
            $adminEmail = config('mail.admin_address', 'admin@youhearus.com'); // Example: Get from config or use default
            $this->emailService->send(
                $adminEmail,
                (new EmailToAdminPayoutRequest($transaction, $user))->forUser($user), // Pass transaction and user to Mailable
                'admin.payout.request', // Email preference key
                $user // User context
            );
            // Consider adding email to curator confirmation here if needed

            // Redirect with success message
            return redirect()->route('curator.wallet')->with(
                'message',
                'Your request has been sent to the admin.'
            );

        } catch (\Exception $e) {
            // Handle potential error during transaction save or email sending
            Log::error("Error creating withdrawal request or sending email for user {$user->id}: " . $e->getMessage());
            return redirect()->route('curator.wallet')->with('error', 'Failed to create withdrawal request due to a system error. Please try again later.');
        }
    }

    public function getPaypal($userId, $address)
    {
        $curatorPaypal = CuratorPaypal::where('user_id', $userId)->first();
        if (!$curatorPaypal) {
            CuratorPaypal::create([
                'user_id' => $userId,
                'paypal_address' => $address
            ]);
        } else {
            if ($curatorPaypal->paypal_address != $address) {
                $curatorPaypal->paypal_address = $address;
                $curatorPaypal->save();
            }
        }
    }

    public function checkUserwallet()
    {
        $user = Auth::user();
        $wallet = $user->wallet;
        return response()->json($wallet);
    }
}
