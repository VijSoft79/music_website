<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\ModelImageTrait;
use Illuminate\Http\Request;
use App\Models\Music;

use Illuminate\Support\Facades\Mail;
use App\Mail\SongApprovalToMusician;

use Carbon\Carbon;
use App\Services\EmailService;

class MusicController extends Controller
{
    use ModelImageTrait;
    protected $emailService;

    public function __construct()
    {
        $this->emailService = app(EmailService::class);
    }
    
    public function index()
    {
        $musics = Music::all();

        foreach ($musics as $music) {
            if ($music->artist) {
                $btnEdit = '<a href="' . route('admin.music.show', $music) . '" class="btn btn-xs btn-default text-primary mx-1 shadow">
                <i class="fa fa-lg fa-fw fa-pen"></i>
                </a>';
                $btnDelete = '<button class="btn btn-xs btn-default text-danger mx-1 shadow" id="delete" title="Delete" data-genre-id="' . $music->id . '">
            <i class="fa fa-lg fa-fw fa-trash"></i>
                </button>';

                $date = date_create($music->release_date);

                if ($music->status == "approve") {
                    $status = '<span class="badge badge-success">Approve</span>';
                } elseif ($music->status == "unpaid") {
                    $status = '<span class="badge badge-warning">Unpaid</span>';
                } elseif ($music->status == "pending") {
                    $status = '<span class="badge badge-danger">Pending</span>';
                } else {
                    $status = '<span class="badge badge-danger">Disapprove</span>';
                }

                $rowData = [
                    $music->id,
                    $music->artist->name,
                    $music->artist->email,
                    $music->title,
                    date_format($date, "M d,Y"),
                    $status,
                    '<nobr>' . $btnEdit . $btnDelete . '</nobr>',
                ];
                $data[] = $rowData;
            }
        }
        return view('admin.music.index', [
            'musics' => $musics,
            'data' => $data
        ]);
    }

    public function show(Music $music)
    {
        return view('admin.music.show', compact(['music']));
    }

    public function update(Music $music)
    {
        // check music if already approve
        if ($music->status == 'unpaid') {
            return redirect()->route('admin.music.index')->with('message', 'Payment Request has been sent to the musician');
        } elseif ($music->status == 'approve') {
            return redirect()->route('admin.music.index')->with('message', 'This music has already been paid and approved');
        }

        $this->approveMusic($music);

        return redirect()->route('admin.music.index');
    }

    public function approveMusic($music)
    {
        $music = Music::find($music->id);
        $music->status = 'unpaid';
        $music->save();
        $this->emailService->send($music->artist->email, (new SongApprovalToMusician($music))->forUser($music->artist), 'music.approval', $music->artist);
    }

    public function adminApproval(Request $request)
    {
        $music = music::find($request->music_id); // Find the music track by ID

        if (!$request->approve) {
            $music->status = 'pending'; // Set status to 'pending' if not approved
            $music->save(); // Save the updated status to the database
            return response()->json(['message' => 'music has been Disaprroved']); // Return a JSON response
        } else {
            $music->status = 'approve'; // Set status to 'approve' if approved
            $music->save(); // Save the updated status to the database
            return response()->json(['message' => 'music has been Approved']); // Return a JSON response
        }


    }

    public function getPendingMusic()
    {
        $musics = Music::where('status', 'pending')->get();
        $data = [];

        foreach ($musics as $music) {
            if ($music->artist) {
                $btnEdit = '<a href="' . route('admin.music.show', $music) . '" class="btn btn-xs btn-default text-primary mx-1 shadow">
                <i class="fa fa-lg fa-fw fa-pen"></i>
                </a>';
                $btnDelete = '<a href="' . route('admin.music.delete', $music) . '" class="btn btn-xs btn-default text-danger mx-1 shadow btn-delete" title="Delete" data-genre-id="' . $music->id . '">
            <i class="fa fa-lg fa-fw fa-trash"></i>
        </a>';

                $date = date_create($music->release_date);

                $rowData = [
                    $music->id,
                    $music->artist->name,
                    $music->artist->email,
                    $music->title,
                    date_format($date, "M d, Y"),
                    '<nobr>' . $btnEdit . $btnDelete . '</nobr>',
                ];
                $data[] = $rowData;
            }

        }


        return view('admin.music.pending', compact(['data']));
    }

    public function getApprovedMusic()
    {
        $musics = Music::where('status', 'approve')->get();
        $data = [];

        foreach ($musics as $music) {
            if ($music->artist) {
                $btnEdit = '<a href="' . route('admin.music.show', $music) . '" class="btn btn-xs btn-default text-primary mx-1 shadow">
                <i class="fa fa-lg fa-fw fa-pen"></i>
                </a>';
                $btnDelete = '<a href="' . route('admin.music.delete', $music) . '" class="btn btn-xs btn-default text-danger mx-1 shadow btn-delete" title="Delete" data-genre-id="' . $music->id . '">
            <i class="fa fa-lg fa-fw fa-trash"></i>
        </a>';

                $date = date_create($music->release_date);

                $rowData = [
                    $music->id,
                    $music->artist->name,
                    $music->artist->email,
                    $music->title,
                    date_format($date, "M d,Y"),
                    '<nobr>' . $btnEdit . $btnDelete . '</nobr>',
                ];
                $data[] = $rowData;
            }
        }

        return view('admin.music.approve', [
            'data' => $data
        ]);
    }

    public function getUnpaidMusic()
    {
        $musics = Music::where('status', 'unpaid')->get();
        $data = [];

        foreach ($musics as $music) {
            if ($music->artist) {
                $btnEdit = '<a href="' . route('admin.music.show', $music) . '" class="btn btn-xs btn-default text-primary mx-1 shadow">
                <i class="fa fa-lg fa-fw fa-pen"></i>
                </a>';
                $btnDelete = '<a href="' . route('admin.music.delete', $music) . '" class="btn btn-xs btn-default text-danger mx-1 shadow btn-delete" title="Delete" data-genre-id="' . $music->id . '">
            <i class="fa fa-lg fa-fw fa-trash"></i>
        </a>';

                $date = date_create($music->release_date);

                $rowData = [
                    $music->id,
                    $music->artist->name,
                    $music->artist->email,
                    $music->title,
                    date_format($date, "M d,Y"),
                    '<nobr>' . $btnEdit . $btnDelete . '</nobr>',
                ];
                $data[] = $rowData;
            }

        }

        return view('admin.music.unpaid', [
            'data' => $data
        ]);
    }

    public function delete(Music $music)
    {
        $music->delete();
        return redirect()->back()->with('message', 'music successfully deleted');
    }

    public function uploadImage(Music $music, Request $request)
    {
        //validate image
        $validated = $request->validate([
            'musicImage' => 'required|image|mimes:jpeg,png,jpg,gif|max:3072',
        ]);

        //pass image trait
        $photoPath = $this->getImage($request->file('musicImage'), Music::find($music->id));

        //update changes
        $music->update([
            'image_url' => $photoPath,
        ]);

        return back()->with('message', 'music image successfully updated');
    }


}
