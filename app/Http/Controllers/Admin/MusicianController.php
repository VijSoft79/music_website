<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\SpecialAccount;

use Illuminate\Support\Facades\Mail;
use App\Mail\EmailToArtistRegister;
use App\Models\Music;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;

class MusicianController extends Controller
{
    public function index()
    {
        $musicians = User::role('musician')->get();
        $data = [];

        foreach ($musicians as $user) {
            $btnEdit = '<a href="' . route('admin.musicians.show', $user) . '" class="btn btn-xs btn-default text-teal mx-1 shadow">
                <i class="fa fa-lg fa-fw fa-eye"></i>
                </a>';
            $btnEditNames = '<button type="button" class="btn btn-xs btn-default text-primary mx-1 shadow" data-toggle="modal" data-target="#editArtistNameModal" data-user-id="' . $user->id . '" data-name="' . $user->name . '" data-band-name="' . $user->band_name . '">
                <i class="fa fa-lg fa-fw fa-pen"></i>
                </button>';
            $btnDelete = '<a href="' . route('admin.musicians.delete', $user) . '" class="btn btn-xs btn-default text-danger mx-1 shadow" onclick="confirm_delete(event)">
            <i class="fa fa-lg fa-fw fa-trash"></i>
                </a>';

            if ($user->is_approve == 0) {
                $status = '<span class="badge bg-danger">Pending Approve</span>';
            } elseif ($user->is_approve == 1) {
                $status = '<span class="badge bg-success">Approve</span>';
            } else {
                $status = '<span class="badge bg-danger">Disapprove</span>';
            }
            $musicCount = $user->music->count();

            $rowData = [
                $user->id,
                $user->name,
                $user->band_name,
                $user->email,
                $musicCount,
                $user->created_at,
                $status,
                '<nobr>' . $btnEditNames . $btnDelete . $btnEdit . '</nobr>',
            ];
            $data[] = $rowData;
        }

        return view('admin.musicians.index', compact(['data']));
    }

    public function show(User $user)
    {
        return view('admin.musicians.show', compact(['user']));
    }

    public function approveMusician(Request $request)
    {
        $user = User::find($request->user_id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $user->is_approve = $user->is_approve == 0 ? 1 : 0;
        if ($user->is_approve == 1) {
            $user->givePermissionTo('can use all');
        } else {
            $user->revokePermissionTo('can use all');
        }
        $user->save();
        // Mail::to($user->email)->send(new EmailToArtistRegister());

        return response()->json('sucess');
    }

    public function delete(User $user)
    {
        Music::where('user_id', $user->id)->delete();
        $user->delete();
        return redirect()->route('admin.musicians.index')->with('message', 'musician Has been deleted');
    }

    public function isSpecial(Request $request)
    {
        $user = User::find($request->userspecial);
        $isSpecial = SpecialAccount::where('user_id', $request->user_id)->first();

        if (!$isSpecial) {
            SpecialAccount::create([
                'user_id' => $request->user_id,
                'is_special' => true
            ]);
        } else {
            $isSpecial->is_special = $request->special;
            $isSpecial->save();
        }
        return response()->json(['message' => 'Successfully Edited']);
    }

    public function verify(Request $request){
        
        $verified = User::find($request->user_id);
   
       
       if ($verified) {
            if (!$verified->email_verified_at) {

                $verified->email_verified_at = now();
                $verified->save();
            }else{
                
            return response()->json([
                'Already' => 'Already verified',
            ]);
                
            }
        
        }
   

       return response()->json([
        'message' => 'Successfully verified',
        ]);
    
    }

    public function downloadMusician()
    {
        //get user that have roles musician
        $musicians = User::whereHas('roles', function ($query) {
            $query->where('name', 'musician');
        })->get();
    
        //if no musician found
        if ($musicians->isEmpty()) {
            return back()->with('error', 'No musician found.');
        }
    
        //loop all musician to csv
        $csvContent = "Name,Email,Songs Submitted\n";
        foreach ($musicians as $musician) {

            $csvContent .= "{$musician->name},{$musician->email},{$musician->music->count()}\n";
        }

        //notif message
        session()->flash('message', 'Successfully Downloaded');
  
        return response($csvContent, 200)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="musicians.csv"');
    }

    public function editArtistName()
    {
        return view('admin.musicians.edit-artist-name');
    }

    public function updateNames(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'band_name' => 'required|string|max:255',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'band_name' => $request->band_name,
        ]);

        return response()->json(['message' => 'Names updated successfully']);
    }
}
