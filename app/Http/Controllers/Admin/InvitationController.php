<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Http\Request;

use App\Models\InvitationForChecking;
use App\Models\BasicOffer;
use App\Models\PremiumOffer;
use App\Models\CuratorWallet;
use App\Models\SpotifyPlaylist;
use App\Models\Transaction;
use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\Mail;
use App\Mail\EmailToCuratorWorkApproved;

// use App\Services\EmailPreferenceService;
use App\Mail\EmailToAdminCompleteWorkSubmited;
use App\Models\FreeAlternative;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\ProcessInvitation;
use App\Services\EmailService;


class InvitationController extends Controller
{
    protected $emailService;

    public function __construct()
    {
        $this->emailService = app(EmailService::class);
    }

    public function index()
    {

        $offers = Offer::whereHas('music', function ($query) {
            $query->whereNull('deleted_at')->whereHas('artist'); // Only get music that has been deleted
        })->with('music')->get();
        $data = [];
        
        foreach ($offers as $offer) {
            

            $rowData = [
                $offer->id,
                $offer->music->title,
                $offer->music->artist->band_name,
                $offer->user->name,
                $offer->date_complete,
                // '<nobr>' . . '</nobr>',
            ];
            $data[] = $rowData;
        }
        return view('admin.invitations.index', compact('data'));
    }

    public function getInvitationReports()
    {

        $reports = InvitationForChecking::where('status', 'pending checking')->get();
        $data = [];

        foreach ($reports as $report) {
            if($report){
                
                $offer = $report->offer;

                $type = $this->getOfferType($offer);

                $btnEdit = '<a href="' . route('admin.invitation.show', $offer) . '" class="btn btn-xs btn-default text-primary mx-1 shadow" id="editBtn" title="Edit">
                    <i class="fa fa-lg fa-fw fa-pen"></i>
                    </a>';
                $checkbox = '<input type="checkbox" class="form-check-input mx-auto" name="action[]" id="offer_' . $offer->id . '" value="' . $offer->id . '">';
                $rowData = [
                    '<nobr>' . $checkbox . '</nobr>',
                    $report->id,
                    $report->offer->music->title,
                    $report->offer->music->artist->band_name,
                    $report->offer->user->name,
                    $report->offer->offer_template_id,
                    $report->offer->date_complete,
                    $type->offer_price ? $type->offer_price : "free" ,
                    '<nobr>' . $btnEdit . '</nobr>',
                ];
                $data[] = $rowData;
            }
        }
        return view('admin.invitations.reports', compact(['data']));
    }

    public static function getOfferType($offer = null)
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

    public function saveReport($offers){

        $offerReport = Offer::where('id', $offers)->first();
        $template = $this->getOfferType($offerReport);

        // get amount of the chosen offer
        $amount = $template->offer_price ? $template->offer_price : 0 ;
        $curator = $offerReport->user;

        $this->emailService->send($offerReport->user->email, (new EmailToCuratorWorkApproved($curator, $amount))->forUser($curator), 'curator.work.approved', $curator);
        $this->emailService->send('admin@youhearus.com', new EmailToAdminCompleteWorkSubmited($offerReport), 'admin.work.submitted', null);
        
        // set offer report status
        $report = $offerReport->report;
        $report->status = 'completed';
        $report->save();

        // set offer status
        $offerReport->status = 2;
        $offerReport->save();

        //add transaction record for curator
        Transaction::create([
            'user_id' => $offerReport->user->id,
            'amount' => $amount,
            'type' => 'invitation-payment',
            'offer_id' => $offerReport->id,
            'status' => 'completed'
        ]);

        // add ammount to wallet
        $wallet = CuratorWallet::where('curator_id', $offerReport->user->id)->first(); // get curator wallet if exist
        if (!$wallet) {
            CuratorWallet::create([
                'curator_id' => $offerReport->user->id,
                'amount' => $amount,
            ]);
        } else {
            $wallet->amount = $amount + $wallet->amount;
            $wallet->save();
        }

        $redirect = [$offerReport->user->name, $offerReport->music->artist->name, $amount];

        return $redirect;
    }


    public function store(Request $request)
    {
        foreach ($request->action as $offers) {
           $var = $this->saveReport($offers);
        }
        
        return  redirect()->route('admin.invitation.reports')->with('message', 'Offer of ' . $var[0] . ' to ' . $var[1] . ', has been Complete, and the amount of ' . $var[2] . ' has been added to its wallet');
    }

    public function show(Offer $offer)
    {
        $invitationReport = InvitationForChecking::where('offer_id', $offer->id)->first();
        // $images = json_decode($invitationReport->images);
        $music = $offer->music;
        if ($offer->offer_type == 'standard') {
            $template = BasicOffer::where('id', $offer->offer_type_id)->first();
        }elseif($offer->offer_type == 'free-option'){
            $template = FreeAlternative::where('id', $offer->offer_type_id)->first();
        }elseif($offer->offer_type == 'spotify-playlist'){
            $template = SpotifyPlaylist::where('id', $offer->offer_type_id)->first();
        } else {
            $template = PremiumOffer::where('id', $offer->offer_type_id)->first();
        }
        
        $reportImages = json_decode($offer->report->images);
        

        return view('admin.invitations.show', compact(['offer', 'music', 'template', 'reportImages', 'invitationReport']));
    }


    public function invitationComplete(Offer $offer,Request $request)
    {
        $var = $this->saveReport($offer->id);
        return  redirect()->route('admin.invitation.reports')->with('message', 'Offer of ' . $var[0] . ' to ' . $var[1] . ', has been Complete, and the amount of ' . $var[2] . ' has been added to its wallet');

    }

    public function getCompletedInvites()
    {
        $offers = Offer::where('status', 2)->get();
        $data = [];

        foreach ($offers as $offer) {
            if ($offer->music) {
                $btnDetails = '<a href="'. route('admin.invitation.show', $offer) .'" class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                    <i class="fa fa-lg fa-fw fa-eye"></i>
                </a>';
                $rowData = [
                    $offer->id,
                    $offer->music->title,
                    $offer->music->artist->band_name,
                    $offer->user->name,
                    $offer->date_complete,
                    '<nobr>' . $btnDetails . '</nobr>',
                ];
                $data[] = $rowData;
            }


        }

        return view('admin.invitations.completed', compact(['data']));
    }

}
