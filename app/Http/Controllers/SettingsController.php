<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EmailMessage;
use App\Models\UserChosenEmail;

class SettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Access the attribute directly
        $emailMessages = EmailMessage::where('email_to', $user->getRoleNames()[0])->get();

        return view('curator.settings.index', compact('emailMessages'));
    }

    public function save(Request $request)
    {
        $user = Auth::user();
        $chosen = $user->chosenEmails->first();

        if ($chosen) {
            $chosen->chosen_emails = json_encode($request->emails);
            $chosen->save();
        } else {
            UserChosenEmail::create([
                'user_id' => $user->id,
                'chosen_emails' => json_encode($request->emails)
            ]);
        }

        return redirect()->back();
    }
}
