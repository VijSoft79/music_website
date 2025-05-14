<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class EmailPreferenceController extends Controller
{
    
    // Toggle the user's email subscription status
    public function toggle(Request $request)
    {
        $user = Auth::user();
        $user->is_email_enabled = $request->boolean('receive_emails');
        $user->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $user->is_email_enabled 
                    ? 'You have been subscribed to email notifications.' 
                    : 'You have been unsubscribed from email notifications.'
            ]);
        }

        return back()->with('success', $user->is_email_enabled 
            ? 'You have been subscribed to email notifications.' 
            : 'You have been unsubscribed from email notifications.');
    }
    
    //Unsubscribe a user from emails using a signed URL
    public function unsubscribe(Request $request, $encryptedUserId)
    {
        if (!$request->hasValidSignature()) {
            abort(401);
        }
        
        try {
            $userId = Crypt::decrypt($encryptedUserId);
            $user = User::findOrFail($userId);
            
            $user->unsubscribeFromEmails();
            
            return view('emails.unsubscribed', ['user' => $user]);
        } catch (\Exception $e) {
            abort(404);
        }
    }
} 