<?php

namespace App\Http\Controllers\Musician;

use App\Http\Controllers\Controller;
use App\Models\Music;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class MusicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $musics = Music::where("user_id", Auth::id())->where('deleted_at', '=', null)->get();

        $data = [];
        $missingData = [];

        foreach ($musics as $music) {

            $btnEdit = '<a href="' . route('musician.music.show', $music) . '" class="btn btn-xs btn-default text-primary mx-1 shadow">
                <i class="fa fa-lg fa-fw fa-eye"></i>
                </a>';

            if($music->remainingDays() == 0){
                $status = '<span class="badge bg-danger">expired</span>';
            }else{
                if($music->status === 'pending'){
                    $status = '<span class="badge bg-danger">'. $music->status . '</span>';
                }elseif($music->status === 'unpaid'){
                    $status = '<span class="badge bg-warning">'. $music->status . '</span>';
                }else{
                    $status = '<span class="badge bg-success">'. $music->status . '</span>';
                }
            }
           

            $rowData = [
                $music->id,
                $music->title,
                Carbon::parse($music->release_date)->format('M d, Y'),
                $status, 
                '<nobr>' . $btnEdit . '</nobr>',
            ];
            $data[] = $rowData;

            // Check for missing fields for each music
            $missingFields = [];
            if (!$music->image_url) $missingFields[] = 'Song Images';
            // if (!$music->audio_file) $missingFields[] = 'Audio File';
            // if (!$music->title) $missingFields[] = 'Title';
            // if (!$music->release_date) $missingFields[] = 'Release Date';
            // if (!$music->release_type) $missingFields[] = 'Release Type';
            // if (!$music->song_version) $missingFields[] = 'Song Version';
            // if (!$music->description) $missingFields[] = 'Description';
            if (!$music->pressQuestion && !$music->release_url) {
                $missingFields[] = 'Press Release or Release File';
            }

            if (!empty($missingFields)) {
                $missingData[$music->id] = [
                    'title' => $music->title ?? 'Untitled',
                    'missing_fields' => $missingFields
                ];
            }
        }

        if (!empty($missingData)) {
            session()->flash('missing_music_data', $missingData);
        }

        return view('musician.music.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Music $music)
    {
        return view('musician.music.show', compact('music'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Music $music)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Music $music)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Music $music)
    {
        $music->delete();
        return back();
    }

    public function markAsRead($id)
    {
        // Find the authenticated user (musician)
        $user = Auth::user();

        // Mark the notification as read
        $user->notifications()->where('id', $id)->first()->markAsRead();

        return response()->json(['success' => true]);
    }

    public function addImages(Request $request, Music $music)
    {
        $request->validate([
            'images' => ['required', 'array', 'min:1'],
            'images.*' => [
                'required',
                'file',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:10000', // 10MB max size
                'dimensions:min_width=300,min_height=300' // Minimum dimensions
            ],
        ], [
            'images.required' => 'At least one image is required.',
            'images.*.image' => 'All uploaded files must be images.',
            'images.*.mimes' => 'Images must be in JPEG, PNG, JPG or GIF format.',
            'images.*.max' => 'Images must not be larger than 10MB.',
            'images.*.dimensions' => 'Images must be at least 300x300 pixels.'
        ]);

        if ($request->hasFile('images')) {
            $disk = Storage::disk('public');
            
            // Create a clean directory name based on music title
            $explodedtitle = explode(" ", $music->title);
            $removeSpecialChar = preg_replace('/[^a-zA-Z0-9]/', '', $explodedtitle);
            $filteredWords = array_filter($removeSpecialChar, function ($word) {
                $cleanedWord = preg_replace('/[^a-zA-Z0-9]/', '', $word);
                return !empty($cleanedWord);
            });
            $implodedTitle = implode('-', $filteredWords);
            $directory = 'music-images/' . $music->id . '-' . $implodedTitle;

            foreach ($request->file('images') as $image) {
                $filename = $image->getClientOriginalName();
                $newFilePath = $directory . '/' . $filename;
                
                // Store the file in the new directory
                $path = $image->storeAs($directory, $filename, 'public');
                
                DB::table('images_music')->insert([
                    'music_id' => $music->id,
                    'image_path' => $path,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }

        return redirect()->back()->with('success', 'Images uploaded successfully');
    }
}
