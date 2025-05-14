<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Traits\ModelImageTrait;

use Illuminate\Support\Facades\Auth;

use App\Models\Update;
use App\Models\Offer;

class CuratorController extends Controller
{
    use ModelImageTrait;

    public function index(){
        $updates = Update::where('update_for', 'curator')->get();
        
        //filter out if title is true
        $updates = $updates->reject(function ($value) {
            return Auth::user()->is_approve == 1 && $value->title == "Welcome to You Hear Us";
        });

        $offer = Offer::where('user_id', Auth::id())->first();
       
        return view('curator.index',[
            'updates' => $updates ,
            'offer' => $offer,
        ]);
    }

    public function update(Request $request)
    {
        
        //for image validation
        if (!Auth::user()->profile_image_url && !Auth::user()->bio && !Auth::user()->contact) {
            $validated = $request->validate([
                'contact' => 'required',
                'email' => 'required',
                'bio' => 'required',
                'image' => 'required'
            ]);
        }else {
            $validated = $request->validate([
                'contact' => 'required',
                'email' => 'required',
                'bio' => 'required',
            ]);
        }

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->bio = $validated['bio'];
        $user->phone_number = $validated['contact'];
        $user->location = $request->location;
        $user->website = $request->website;

        //curators socials
        $user->facebook_link = $request->facebook_link;
        $user->instagram_link = $request->instagram_link;
        $user->spotify_link = $request->spotify_link;
        $user->tiktok_link = $request->tiktok_link;
        $user->youtube_link = $request->youtube_link;
        $user->soundcloud_link = $request->soundcloud_link;
        $user->songkick_link = $request->songkick_link;
        $user->bandcamp_link = $request->bandcamp_link;
        $user->telegram = $request->telegram;
        $user->twitter_link = $request->twitter_link;
        
        
        $user->date_founded = $request->date_founded;
        $user->message_to_admin = $request->message_to_admin;

        // additional information
        $user->contribution_bio = $request->contribution_bio;
        $user->total_reviews = $request->total_reviews;
        $user->estimated_visitor = $request->estimated_visitor;

        $paypalEmail = $request->paypal;
        if ($paypalEmail) {
            $user->paypal()->updateOrCreate(
                ['user_id' => $user->id],  // Match on the user_id
                ['paypal_address' => $paypalEmail]   // Update the email
            );
        }


         // image upload here
        if ($request->hasFile('image')) {
            // $image = $request->file('image');
            // $imageName = $image->getClientOriginalName();
            // dd($imageName);

            $user->profile_image_url = $this->getImage($request['image'], $user );
        }

        $user->save();

        return redirect(route('curator.home'))->with('message', 'Profile successfully updated');
    }

    public function submissionsShow()
    {
        return view('curator.submissions.show');
    }

    public function show()
    {
        $countries = countries();
        // dd($countries);

        $user = Auth::user();
        return view('curator.show', compact('user', 'countries'));
    }
}
