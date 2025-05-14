<?php

namespace App\Http\Controllers\Musician;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\ChatMessage;

use App\Models\Offer;
use App\Models\Music;
use App\Models\OfferTemplate;
use App\Models\BasicOffer;
use App\Models\PremiumOffer;
use App\Models\FreeAlternative;
use App\Models\SpotifyPlaylist;

use Carbon\carbon;


class InvitationController extends Controller
{
    public function index()
    {
        return view('musician.invitations.index');
    }

    public function getInProgressOffer()
    {
        return view('musician.invitations.inprogress');
    }

    public function getCompletedOffer()
    {
        return view('musician.invitations.completed');
    }

    public function show(Offer $offer)
    {
        $offer = Offer::findOrFail($offer->id);

        // Only allow if this user owns the offer

        if ($offer->music->artist) {
        
            if (auth()->user()->id !== $offer->music->artist->id) {
                return redirect()
                    ->route('musician.index')
                    ->withErrors(['error' => 'You are not authorized to visit the page']);
            }
        }else {
            return redirect()
                    ->route('musician.index')
                    ->withErrors(['error' => 'Artist no records']);

        }

        $template = OfferTemplate::findOrFail($offer->offer_template_id);
        $music = Music::where('id', $offer->music_id)->first();

        $messages = ChatMessage::where('offer_id', $offer->id)->get();

        $chosenInvitation = $this->getChosenOffer($offer->offer_type, $offer->offer_type_id);

        return view('musician.invitations.show', [
            'offer' => $offer,
            'template' => $template,
            'music' => $music,
            'messages' => $messages,
            'chosenInvitation' => $chosenInvitation,
        ]);
    }

    public function declineInvitation(Request $request)
    {
        $offer = Offer::find($request->offerId);
        $offer->status = 4;
        $offer->save();
        return response()->json(['message', 'Offer has been declined'], 200);
    }

    public function getChosenOffer($offerType, $offerTypeId)
    {
        switch ($offerType) {
            case 'premium':
                $offer = PremiumOffer::find($offerTypeId);
                break;
            case 'free-option':
                $offer = FreeAlternative::find($offerTypeId);
                break;
            case 'spotify-playlist':
                $offer = SpotifyPlaylist::find($offerTypeId);
                break;
            default:
                $offer = BasicOffer::find($offerTypeId);
        }

        return $offer;
    }
}
