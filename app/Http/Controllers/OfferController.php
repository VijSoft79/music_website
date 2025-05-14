<?php

namespace App\Http\Controllers;

use App\Mail\ChatEmail;
use App\Models\ChatNotificationLog;
use App\Models\SpotifyPlaylist;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Offer;

use Illuminate\Support\Facades\Mail;
use App\Mail\CuratorOfferToMusician;
use App\Mail\EmailToAdminCompleteWorkSubmited;
use App\Mail\EmailToMusicianWhenWorkIsDone;

use App\Models\Music;

use Carbon\Carbon;

use App\Models\OfferTemplate;
use Illuminate\Support\Facades\Redirect;
use App\Models\ChatMessage;
use App\Models\InvitationForChecking;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;

use App\Models\BasicOffer;
use App\Models\PremiumOffer;
use App\Models\FreeAlternative;

use App\Services\EmailService;

class OfferController extends Controller
{
    protected $emailService;

    public function __construct()
    {
        $this->emailService = app(EmailService::class);
    }

    public function index()
    {
        return view('curator.offers.index');
    }

    public function getInProgressOffer()
    {
        return view('curator.offers.in-progress');
    }

    public function getCompletedOffer()
    {
        return view('curator.offers.completed');
    }

    public function getDeclinedOffer()
    {
        $declined = Offer::where('user_id', Auth::id())
            ->whereIn('status', [3, 4])
            ->whereHas('music', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->with('music.artist')
            ->doesntHave('report')
            ->orderBy('date_complete', 'desc')
            ->get();

        $data = [];
        foreach ($declined as $decline) {
            if (!$decline->music || !$decline->music->artist) {
                continue;
            }

            $offer = $decline->offer;

            $btnShow = '<a href="' . route('curator.submissions.show', $decline->music) . '" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Show Music Details">
                <i class="fa fa-lg fa-fw fa-eye"></i>
                </a>';

            // Determine who declined and wrap in Bootstrap badge
            $declinedBy = ($decline->status == 4) 
                ? '<span class="badge badge-warning">' . $decline->music->artist->band_name . '</span>' 
                : '<span class="badge badge-primary">You</span>';

            $rowData = [
                $decline->id,
                $decline->music->title,
                $decline->music->artist->band_name,
                $declinedBy,
                '<nobr>' . $btnShow . '</nobr>',
            ];
            $data[] = $rowData;
        }

        return view('curator.offers.declined', compact(['data']));
    }

    public function reports()
    {
        $reports = InvitationForChecking::where('status', 'pending checking')->get();
        $data = [];
        foreach ($reports as $report) {
            if ($report->offer->user->id == Auth::user()->id) {

                $offer = $report->offer;
                $btnShow = '<a href="" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Show">
                    <i class="fa fa-lg fa-fw fa-eye"></i>
                    </a>';
                $rowData = [
                    $report->id,
                    $report->offer->music->title,
                    $report->offer->music->artist->name,
                    Carbon::parse($report->offer->date_complete)->format('M d, Y'),
                    '<nobr>' . $btnShow . '</nobr>',
                ];
                $data[] = $rowData;
            }
        }
        return view('curator.offers.report', compact(['data']));

    }

    public function saveForCheckingOffer(Offer $offer, Request $request)
    {

        $checking = InvitationForChecking::where('offer_id', $offer->id)->first();

        if ($checking) {
            return redirect()->route('curator.offers.show', $offer->id)->with('message', 'Your report Is being check.');
        }


        $uploadedImages = [];
        $InvitationForChecking = InvitationForChecking::create([
            'offer_id' => $offer->id,
            'status' => 'pending checking',
            'url' => json_encode($request->sample_link),
        ]);

        if ($request->hasFile('checkImages')) {

            foreach ($request->file('checkImages') as $image) {

                $path = $image->store('uploads/offer-checking-' . $offer->id, 'public');
                $uploadedImages[] = $path;

                if (!Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->makeDirectory($path);
                }
            }

            $InvitationForChecking->images = json_encode($uploadedImages);
            $InvitationForChecking->save();

            $this->emailService->send('admin@youhearus.com', new EmailToAdminCompleteWorkSubmited($offer), 'admin.work.submitted', null);
            $this->emailService->send($offer->music->artist->email, (new EmailToMusicianWhenWorkIsDone($offer))->forUser($offer->music->artist), 'musician.work.done', $offer->music->artist);
        }
        $offer->date_complete = Carbon::now();
        $offer->save();

        return redirect()->route('curator.offers.show', $offer->id)->with('message', 'Your report has been sent to the admin and is being check. Youhearus.com will email you after the checking is done');
    }

    public function show(Offer $offer) 
    {
        $offer = Offer::findOrFail($offer->id);

        if ($offer->user) {

            // Only allow if this user owns the offer
            if (auth()->user()->id !== $offer->user_id) {
                return redirect()
                    ->route('curator.home')
                    ->withErrors(['error' => 'You are not authorized to visit the page']);
            }
        }else {
            return redirect()
            ->route('curator.home')
            ->withErrors(['error' => 'Curator no records']);
        }

        $template = OfferTemplate::where('id', $offer->offer_template_id)->first();

        $music = $offer->music;
        $messages = ChatMessage::where('offer_id', $offer->id)->get();

        return view('curator.offers.show', [
            'offer' => $offer,
            'template' => $template,
            'music' => $music,
            'messages' => $messages,
        ]);
    }

    public function sendInvitation(Request $request)
    {

        $validate = $request->validate([
            'expires_at' => 'required',
            'date_complete' => 'required'
        ]);

        if ($request->marketing_option_standard || $request->marketing_option_premium) {
            $marketingSpends = [
                $request->marketing_option_standard ?? 'nostandard',
                $request->marketing_option_premium ?? 'nopremium',
            ];
        } else {
            $marketingSpends = null;
        }

        $formattedDate = Carbon::parse($validate['expires_at'])->format('Y-m-d');

        $template = OfferTemplate::find($request->templateID);
        $music = Music::find($request->musicId);
        $existingOffer = Offer::where('music_id', $request->musicId)
            ->where('user_id', Auth::user()->id)
            ->where('offer_template_id', $request->templateID)
            ->first();

        if ($existingOffer) {
            return redirect()->route('curator.offers.index')->with('message', 'Your Invitation has been already sent');
        }

        $invitation = Offer::create([
            'music_id' => $request->musicId,
            'user_id' => Auth::user()->id,
            'offer_template_id' => $request->templateID,
            'status' => 0,
        ]);

        $invitation->marketing_spend_option = $marketingSpends ? json_encode($marketingSpends) : null;
        // dd($invitation->marketing_spend_option);
        $invitation->expires_at = $formattedDate;
        $invitation->date_complete = Carbon::parse($validate['date_complete']);
        $invitation->save();


        if ($invitation->save()) {

            $chatMessage = $template->basicOffer->introduction_message;

            $data = [
                '[musician]' => $music->artist->name,
                '[music]' => $music->title,
            ];

            $firstChatMessage = str_replace(array_keys($data), array_values($data), $chatMessage);

            $chat = new ChatMessage();
            $chat->sender_id = Auth::user()->id;
            $chat->reciever_id = $music->user_id;
            $chat->offer_id = $invitation->id;
            $chat->content = $firstChatMessage;
            $chat->save();

            $dataMessage = [
                'sender' => Auth::user(),
                'reciever' => User::find($music->artist->id),
                'content' => $firstChatMessage,
                'sent_at' => $chat->created_at->format('Y-m-d H:i:s'),
                'offer_id' => $invitation->id
            ];


        }


        if ($template->has_premium) {
            $premiumTitle = $template->premiumOffer->name;
            $premuimContent = $template->premiumOffer->introduction_message;
            $basicTitle = $template->basicOffer->name;
            // $itntroMessage = $template->basicOffer->introducion_message;

            $this->emailService->send(
                $music->artist->email,
                (new CuratorOfferToMusician($invitation, $basicTitle, $music->title, $premiumTitle, $premuimContent))->forUser($music->artist),
                'curator.offer',
                $music->artist
            );
        } else {
            $this->emailService->send(
                $music->artist->email,
                (new CuratorOfferToMusician($invitation, $template->basicOffer->name, $music->title))->forUser($music->artist),
                'curator.offer',
                $music->artist
            );
        }

        return redirect()->route('curator.submissions.index')->with('message', 'Your Invitation has been sent');
    }

    public function destroy(Offer $offer)
    {
        $offer->delete();
        return redirect()->route('curator.offers.index')->with('message', 'Offer Deleted Successfully');
    }

    public function declineMusic(Request $request)
    {
        Offer::create([
            'music_id' => $request->musicId,
            'user_id' => Auth::user()->id,
            'offer_template_id' => 0,
            'status' => 3,
        ]);

        return response()->json(['message', 'Music declined'], 200);
    }

    public function changeDate(Request $request)
    {
        $offer = Offer::findOrFail($request->offer);
        $datetime = Carbon::parse($request->date);
        $date = $datetime->format('Y-m-d');
        $offer->date_complete = $date;
        $offer->save();

        return back()->with(['message' => 'Date successfully updated']);
    }

    public static function getTemplate($offer = null)
    {
        $invitation = Offer::findOrFail($offer->id);
        switch ($invitation->offer_type) {
            case 'premium':
                $template = PremiumOffer::where('id', $invitation->offer_type_id)->first();
                break;
            case 'free-option':
                $template = FreeAlternative::where('id', $invitation->offer_type_id)->first();
                break;
            case 'standard':
                $template = BasicOffer::where('id', $invitation->offer_type_id)->first();
                break;
            default:
                $template = SpotifyPlaylist::where('id', $invitation->offer_type_id)->first();
        }

        return $template;
    }

    public static function updateExpiry(Offer $offer, Request $request)
    {
        $offer->expires_at = $request->edit_expiry;
        $offer->update();

        return back()->with('message', 'Expire date successfully updated');
    }


    public function retractOffer(Request $request)
    {
        try {
            $offerId = Crypt::decryptString($request->input('offer_id'));
            $offer = Offer::findOrFail($offerId);

            if($offer->status == 0) {
                $offer->delete();
                
                if($request->ajax()) {
                    // Prepare flash message data for localStorage
                    $flash = [
                        'type' => 'success',
                        'message' => 'Offer retracted successfully.'
                    ];
                    return response()->json([
                        'success' => true,
                        'message' => 'Offer retracted successfully.', // Keep message for Swal
                        'redirect_url' => route('curator.submissions.index'), // Add redirect URL
                        'flash' => $flash // Add flash data for localStorage
                    ]);
                }
                
                return redirect()->route('curator.submissions.index')->with('success', 'Invitation retracted successfully.'); // Non-AJAX redirect
            } else {
                if($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Only pending invitations can be retracted.'
                    ], 422);
                }
                
                return redirect()->back()->with('error', 'Only pending invitations can be retracted.');
            }
        } catch (\Exception $e) {
            if($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Something went wrong. Invalid invitation.'
                ], 422);
            }
            
            return redirect()->back()->with('error', 'Something went wrong. Invalid invitation');
        }
    }
}
