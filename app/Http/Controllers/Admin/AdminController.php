<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CuratorWallet;
use App\Models\InvitationForChecking;
use App\Models\Offer;
use App\Models\OfferTemplate;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Genre;
use App\Models\Music;
use App\Models\User;
use App\Models\Price;

use Illuminate\Mail\PendingMail;
use Psy\Command\WhereamiCommand;
use SebastianBergmann\CodeCoverage\Report\Xml\Report;

class AdminController extends Controller
{
    public function index()
    {
        $musics = Music::all();
        $totalMusicCount = $musics->count();
        $pending = Music::where('status', 1)->count();
        $approve = Music::where('status', 0)->count();
        $musicCount = [$totalMusicCount, $approve, $pending];
        $transactions = Transaction::where('type', 'withdrawal-request')->get()->sortByDesc('created_at')->groupBy('user_id')->map->first();
        $offerReports = InvitationForChecking::all();


        $users = User::with('roles')->get();
        $totalCurator = [0, 0, 0];
        $totalMusician = [0, 0, 0];

        foreach ($users as $user) {
            $roles = $user->roles;
            $usersStatus = $user->is_approve;

            foreach ($roles as $role) {
                if ($role->name === 'musician') {

                    $totalMusician[0]++;

                    if ($usersStatus === 1) {
                        $totalMusician[1]++;
                    } else {
                        $totalMusician[2]++;
                    }


                } elseif ($role->name === 'curator') {

                    $totalCurator[0]++;

                    if ($usersStatus === 1) {
                        $totalCurator[1]++;
                    } else {
                        $totalCurator[2]++;
                    }

                }


            }

        }
        $offerTemplate = OfferTemplate::all();

        $wallets = CuratorWallet::selectRaw('curator_id, SUM(amount) as total_amount')
            ->groupBy('curator_id')
            ->having('total_amount', '>', 0)
            ->orderBy('total_amount', 'desc')
            ->get();

        //get total amount of all inprogress transaction
        $offers = Offer::where('status', 1)->get();
        $totalInprogress = 0;
        
        foreach ($offers as $offer) {
            $template = $offer->findTemplate($offer->offer_type, $offer->offer_type_id);
            $totalInprogress += $template->offer_price ?? 0;
        }

        //get invitation checking
        $checkings = InvitationForChecking::where('status','pending checking')->get();
        $totalCompleted = 0;
        
        foreach ($checkings as $checking) {
            $offerTemplte = $checking->offer->findTemplate($checking->offer->offer_type,$checking->offer->offer_type_id);
            $totalCompleted += $offerTemplte->offer_price ?? 0;
        }

        foreach ($wallets as $wallet) {

            $rowData = [
                'curator_id' => $wallet->curator_id,
                'email' => $wallet->curator->email,
                'total_amount' => $wallet->total_amount,
            ];
            $data[] = $rowData;
        }
        return view('admin.index', compact('totalCompleted','totalInprogress','musics', 'musicCount', 'totalCurator', 'totalMusician', 'data', 'offerTemplate', 'transactions', 'offerReports'));
    }

    public function getMusicians()
    {
        return view('admin.musicians.index');
    }

    public function changeSongPrice(Request $request)
    {

        $request->validate([
            'song_price' => 'required|numeric|min:1'
        ]);

        $songPrice = Price::first();
        if (!$songPrice) {
            Price::create([
                'amount' => $request->song_price
            ]);
        } else {
            $songPrice->amount = $request->song_price;
            $songPrice->save();
        }
        return response()->json([
            'message' => 'Price changed successfully'
        ], 200);
    }

}
