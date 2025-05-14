<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OfferTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Update;
use App\Models\Offer;
// use Illuminate\Support\Facades\Response;


use Illuminate\Support\Facades\Mail;
use App\Mail\EmailToCuratorWhenAccountIsApprove;

use App\Models\User;
use App\Services\EmailService;

class CuratorController extends Controller
{
    protected $emailService;

    public function __construct()
    {
        $this->emailService = app(EmailService::class);
    }

    public function index()
    {
        $curators = User::role('curator')->get();

        $data = [];
        foreach ($curators as $curator) {
            $btnEdit = '<a href="' . route('admin.curators.edit', $curator) . '" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                <i class="fa fa-lg fa-fw fa-pen"></i>
            </a>';
            $btnDelete = '<a href="' . route('admin.curators.delete', $curator) . '" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete" onclick="confirm_delete(event)">
                    <i class="fa fa-lg fa-fw fa-trash"></i>
                </a>';
            $btnDetails = '<a href="' . route('admin.curators.show', $curator) . '" class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details" >
                    <i class="fa fa-lg fa-fw fa-eye"></i>
                </a>';

            if ($curator->is_approve == 0) {
                $status = '<span class="badge bg-danger">Pending Approve</span>';
            } elseif ($curator->is_approve == 1) {
                $status = '<span class="badge bg-success">Approve</span>';
            } else {
                $status = '<span class="badge bg-danger">Disapprove</span>';
            }

            $rowData = [
                $curator->id,
                $curator->name,
                $curator->email,
                $curator->phone_number,
                $curator->created_at->format('d-m-Y'),
                $status,
                '<nobr>' . $btnEdit . $btnDelete . $btnDetails . '</nobr>',
            ];
            $data[] = $rowData;
        }

        return view('admin.curators.index', compact('data'));
    }

    public function show(User $user)
    {
        $WalletTotalAmount = 0;
        if ($user->wallet) {
            $wallets = $user->wallet->where('curator_id',$user->id)->get();
            $WalletTotalAmount = 0;
            foreach ($wallets as $wallet) {
                $WalletTotalAmount += $wallet->amount; 
            }
        }
      
        $data = [];
        $curatorOffers = $user->Offer;
 
        foreach ($curatorOffers as $curatorOffer) {
         

            if ($curatorOffer->music) {
                $value = 'waiting';
                if ($curatorOffer->offer_type) {
                    if ($curatorOffer->offer_type == 'standard') {
    
                        $value = $curatorOffer->offerTemplate->basicOffer->offer_price;
                    }elseif($curatorOffer->offer_type == 'premium'){
    
                        $value = $curatorOffer->offerTemplate->premiumOffer->offer_price;
                    }elseif($curatorOffer->offer_type == 'free-option'){
    
                        $value = 0;
                    }else {
    
                        $value = 0;
                    }
                }
                $status = '';
                if ($curatorOffer->status == 0) {
                    $status = '<span class="badge bg-danger">Pending</span>';
                }elseif ($curatorOffer->status == 1) {
                    $status = '<span class="badge bg-warning">In progress</span>';
                }elseif ($curatorOffer->status == 2) {
                    $status = '<span class="badge bg-info">Complete</span>';
                }elseif ($curatorOffer->status == 3) {
                    $status = '<span class="badge bg-success">Music declined</span>';
                }elseif ($curatorOffer->status == 4) {
                    $status = '<span class="badge bg-primary">Decline</span>';
                }
                $offerMusic = $curatorOffer->music->title;

                $btnDetails = '<a href="' . route('admin.curators.history', $curatorOffer->id) . '" class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details" >
                    <i class="fa fa-lg fa-fw fa-eye"></i>
                </a>';

                $rowData = [
                    $curatorOffer->id,
                    $curatorOffer->offer_type == null ? '<span><b>Waiting</b></span>' : $curatorOffer->offer_type,
                    $offerMusic,
                    $status,
                    $value,
                    $curatorOffer->created_at->format('d-m-Y'),
                    '<nobr>' . $btnDetails . '</nobr>',
                ];
                $data[] = $rowData;
            }
        }
        $data1 = [];
        $curatorTemplates = OfferTemplate::where('user_id', $user->id)->get();

        // user templates
        foreach ($curatorTemplates as $curatorTemplate) {

            $rowData = [
                $curatorTemplate->id,
                $curatorTemplate->basicOffer->name,
                $curatorTemplate->curator->name,
                $curatorTemplate->status == 1 ? 'Approve' : 'Pending',
                $curatorTemplate->premiumOffer ? 'Yes' : 'No',
                
            ];
            $data1[] = $rowData;

        }

        // user transactions
        $transactions = [];
        $curatorTransactions = $user->transactions;
        foreach ($curatorTransactions as $curatorTransaction) {

            $rowData = [
                $curatorTransaction->id,
                $curatorTransaction->amount,
                $curatorTransaction->type,
                $curatorTransaction->status,
                $curatorTransaction->offer_id,
                $curatorTransaction->created_at,
                
            ];
            $transactions[] = $rowData;
        }

        return view('admin.curators.show', compact('user', 'data', 'data1', 'WalletTotalAmount','transactions'));
    }


    public function edit(User $user)
    {
        return view('admin.curators.edit', compact('user'));
    }

    public function update(Request $request)
    {

        // dd($request->all());



        $user = User::where('id', $request->user_id)->first();
        $user->name = $request->name;
        $user->facebook_link = $request->facebook_link;
        $user->bio = $request->bio;
        $user->contribution_bio = $request->contribution_bio;
        $user->instagram_link = $request->instagram_link;
        $user->location = $request->location;
        $user->spotify_link = $request->spotify_link;
        $user->tiktok_link = $request->tiktok_link;
        $user->youtube_link = $request->youtube_link;
        $user->soundcloud_link = $request->soundcloud_link;
        $user->songkick_link = $request->songkick_link;
        $user->bandcamp_link = $request->bandcamp_link;
        $user->telegram = $request->telegram;
        $user->twitter_link = $request->twitter_link;
        $user->website = $request->website;
        $user->phone_number = $request->phone_number;
        $user->date_founded = $request->date_founded;
        $user->message_to_admin = $request->message_to_admin;
        $user->total_reviews = $request->total_reviews;
        $user->estimated_visitor = $request->estimated_visitor;

        if ($request->new_password) {
            $validated = $request->validate([
                'new_password' => ['confirmed'],
            ]);
            $user->password = Hash::make($validated['new_password']);
        }

        $user->save();

        return back();
    }

    public function delete(User $user)
    {
        $user->delete();
        return redirect()->route('admin.curators.index');
    }

    public function approveCurator(Request $request)
    {
        $user = User::find($request->user_id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // $user->is_approve = $user->is_approve == 0 ? 1 : 0;
        if ($user->is_approve == 0) {
            $user->is_approve = 1;
            $this->emailService->send($user->email, (new EmailToCuratorWhenAccountIsApprove())->forUser($user), 'curator.approved', $user);
        } else {
            $user->is_approve = 0;
        }

        if ($user->is_approve == 1) {
            $user->givePermissionTo('can use all');
        } else {
            $user->revokePermissionTo('can use all');
        }

        $user->save();
        return response()->json('sucess');

    }

    public function history(Offer $offer)
    {
        // dd($offer);
        return view('admin.curators.history', compact('offer'));
    }

    public function downloadCurators()
    {
        // Fetch users with the role of "curator"
        $curators = User::whereHas('roles', function ($query) {
            $query->where('name', 'curator');
        })->get(['name', 'email']);

        // If no curators are found, handle gracefully
        if ($curators->isEmpty()) {
            return response()->json(['message' => 'No curators found.'], 404);
        }

        // Prepare the CSV content
        $csvContent = "Name,Email\n";
        foreach ($curators as $curator) {
            $csvContent .= "{$curator->name},{$curator->email}\n";
        }
        session()->flash('message', 'Successfully Downloaded');
        // Create and return a response with CSV headers
        return response($csvContent, 200)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="curators.csv"');
    }

}
