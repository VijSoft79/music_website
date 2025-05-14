<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Music;
use App\Models\Offer;
use App\Models\Update;
use App\Models\PageMessage;
use App\Models\Coupon;
use App\Models\AdminSetting;

use Illuminate\Support\Facades\Mail;
use App\Mail\EmailToMusicianWhenProfileComplete;


use App\Traits\ModelImageTrait;


class MusicianController extends Controller
{
    use ModelImageTrait;

    public function index()
    {
        $user = Auth::user();
        $musicWithOffers = $user->music()->whereHas('offers')->get();
        $offerIds = $musicWithOffers->pluck('id')->toArray();

        $offers = Offer::whereIn('music_id', $offerIds)
            ->where('status', 0)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        $updates = Update::where('update_for', 'musician')->get();

        $unpaids = $this->getUnpaidMusic();
        $unshowed = $user->music()->where('status', '!=', 'approve')->get();
        $approves = $user->music()->where('status', 'approve')->get();
        
        $userStatusMessage = $this->userStatusMessage();
        
        
        $musics = $user->music()->where('deleted_at', '=', null)->get();

        $musicStatusMessages = [];
        foreach ($musics as $music) {
            $musicStatusMessages[] = $this->musicStatusMessage($music);
        }

        $userMusics = Music::where('user_id', Auth::user()->id)->first();
        $firstSongmessage = null;
        
        if (!$userMusics) {
            $firstSongmessage = 'Your first song listing is on us! <a href="' . route('musician.create.step.one') . '">Click Here</a> to list your very first song for free.';
        }

        return view('musician.index', [
            'music' => $musicWithOffers,
            'offers' => $offers,
            'updates' => $updates,
            'unpaids' => $unpaids,
            'unshowed' => $unshowed,
            'approves' => $approves,
            'firstSongmessage' => $firstSongmessage,
            'userStatusMessage' => $userStatusMessage,
            'musicStatusMessages' => $musicStatusMessages,
        ]);
    }

    public function show()
    {
        $countries = countries();

        return view('musician.show', compact('countries'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'band_name' => 'required',
            'email' => 'required',
            'genre' => 'required',
            'location' => 'required',
            'bio' => 'required'
        ]);


        //image validation
        if (!Auth::user()->profile_image_url) {
            $validate = $request->validate([
                'image' => 'required',
            ]);
        }

        $user = User::find($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->band_name = $request->band_name;
        $user->genre = $request->genre;
        $user->location = $request->location;
        $user->bio = $request->bio;

        // musician socials
        $user->website = $request->website;
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

        // iamge updaloed
        if ($request->hasFile('image')) {
            $user->profile_image_url = $this->getImage($request['image'], $user);
        }
        $user->save();

        // email musician
        Mail::to('admin@youhearus.com')->send(new EmailToMusicianWhenProfileComplete($user));

        return redirect()->route('musician.index')->with([
            'message' => 'Profile Updated Succesfully',
            'status' => 'success'
        ],);
    }

    public function destroy(Music $music)
    {
        $music->delete();
        return redirect()->route('musician.music.index')->with('success, Music Deleted SuccessFully');
    }

    public function getUnpaidMusic()
    {
        $music = Music::where('user_id', Auth::user()->id)->where('status', 'unpaid')->get();
        return $music;
    }

    public function userStatusMessage()
    {
        $content = '';
        if (Auth::user()->is_approve == 0) {
            if (Auth::user()->location && Auth::user()->band_name && Auth::user()->genre && Auth::user()->bio) {
                $content = $this->getMessage('Message After Musician Completes Profile');
            } else {

                $approve = AdminSetting::where('name', 'autoApproveSong')->first();
                $artist = AdminSetting::where('name', 'autoApproveMusician')->first();

                if($approve && $artist){

                    $content = $this->getMessage('Message After Band Registers');
                }else{
                    $content = $this->getMessage('Message After Band Registers');
                }
            }
        } else {
            if (Auth::user()->location && Auth::user()->genre && Auth::user()->bio) {
                if(!Auth::user()->music->count()){
                    // $content = $this->getMessage('message after musician completes profile');
                    $content = 'Your first song listing is on us! <a href="' . route('musician.create.step.one') . '">Click Here</a> to list your very first song for free.';
                }
            } else {
                $approve = AdminSetting::where('name', 'autoApproveSong')->first();
                $artist = AdminSetting::where('name', 'autoApproveMusician')->first();

                if($approve && $artist){
                    $content = $this->getMessage('message after band registers (Pre Approve On)');
                }else{
                    
                    $content = $this->getMessage('message after band registers');
                }
            }
        }
        return $content;
    }

    public function musicStatusMessage($music)
    {
        $status = $music->status;
        $noInvites = $music->offers->count() == 0;
        $offersCount = $music->offers->count();
        $message = null;

        if ($noInvites && $status == 'approve') {
            $message = PageMessage::where('name', 'message when the song has no invites yet')->first();
        } else {
            switch ($status) {
                case 'pending':
                    $message = PageMessage::where('name', 'message after song is submitted')->first();
                    break;
                case 'unpaid':
                    $message = PageMessage::where('name', 'message after admin approves musicians song')->first();
                    break;
                default:
                    $message = null;
                    break;
            }
        }

        if ($message) {
            $content = $message->content;
        } else {
            $content = 'No specific message found for this status or invite condition.';
        }

        $data = [
            '{musictitle}' => $music->title,
            '{musicid}' => $music->id,
        ];

        $customMessage = $content;
        foreach ($data as $placeholder => $value) {
            $customMessage = str_replace($placeholder, $value, $customMessage);
        }

        return [
            'status' => $status,
            'message' => $customMessage,
            'music_id' => $music->id,
            'offers_count' => $offersCount
        ];
    }

    public function getMessage($name){
        
        $message = PageMessage::where('name', $name)->first();
        $content = $message ? $message->content : '';
        
        $data = [
            '{bandname}' => Auth::user()->name,
        ];
        foreach ($data as $placeholder => $value) {
            $content = str_replace($placeholder, $value, $content);
        }

        return $content;
    } 


}
