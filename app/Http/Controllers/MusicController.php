<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Music;
use App\Models\Genre;
use App\Models\AdminSetting;
use App\Traits\ModelImageTrait;
use App\Traits\ModelFileTrait;
use Illuminate\Support\Facades\Auth;
use App\Rules\AllowedEmbedDomain;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Mail;
use App\Mail\AdminNotificationOnMusicSubmit;
use App\Mail\EmailToMusicianWhenSongIsSubmited;
use App\Mail\EmailToMusicianWhenSongIsFree;
use App\Mail\SongApprovalToMusician;
use App\Models\PressReleaseQuestions;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Str;

use Carbon\Carbon;

use App\Services\EmailService;

class MusicController extends Controller
{
    use ModelImageTrait;
    // use ModelFileTrait;

    protected $emailService;

    public function __construct()
    {
        $this->emailService = app(EmailService::class);
    }

    public function musicCreate(Request $request)
    {
        if (!Auth::user()->profile_image_url) {

            return redirect()->route('musician.show')->withErrors(['message' => 'Please upload a profile picture']);
        }

        $music = $request->session()->get('music');
        return view('musician.music.create', compact('music'));
    }

    public function postCreateStepOne(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'title' => 'required',
            'release_date' => 'required|date',
            'release_type' => 'required',
            'song_version' => 'required',
            'description' => 'required',
        ]);

        if (!$request->pressRelease) {
            $noteData = $request->validate([
                'PressNote0' => 'required',
                'PressNote1' => 'required',
                'PressNote2' => 'required',
                'PressNote3' => 'required',
                'PressNote4' => 'required',
                'PressNote5' => 'required',
                'PressNote6' => 'required',
                'PressNote7' => 'required'
            ]);
        }else {
            $noteData = $request->validate([
                'releaseFile' => 'required', 'mimes:pdf,doc,docx,txt,xlsx', 'max:4100',
            ]);

            $filePath = null;
            if ($request->pressRelease) {
                $file = $request->file('releaseFile');
                $fileName = Str::random(40) . '.' . $file->getClientOriginalExtension();
                $filePath = $file->storeAs('temp', $fileName, 'public');
            }
        }

        $songRelease = null;
        $request->wait_for_song_release == null ? $songRelease = 0 : $songRelease = 1;

        $request->session()->put('music', [
            'title' => $validatedData['title'],
            'release_date' => $validatedData['release_date'],
            'release_type' => $validatedData['release_type'],
            'song_version' => $validatedData['song_version'],
            'description' => $validatedData['description'],
            'wait_for_song_release' => $songRelease,
        ]);
        if (!$request->pressRelease) {
            $request->session()->put('music.PressNote0', $noteData['PressNote0']);
            $request->session()->put('music.PressNote1', $noteData['PressNote1']);
            $request->session()->put('music.PressNote2', $noteData['PressNote2']);
            $request->session()->put('music.PressNote3', $noteData['PressNote3']);
            $request->session()->put('music.PressNote4', $noteData['PressNote4']);
            $request->session()->put('music.PressNote5', $noteData['PressNote5']);
            $request->session()->put('music.PressNote6', $noteData['PressNote6']);
            $request->session()->put('music.PressNote7', $noteData['PressNote7']);
        }else {
            $request->session()->put('music.release_url', $filePath);
        }


        if ($request->note) {
            $request->session()->put('music', array_merge(session('music', []), ['note' => $request->note]));
        }
        return redirect()->route('musician.create.step.two');
    }

    public function createStepTwo(Request $request)
    {
        $music = $request->session()->get('music');
        return view('musician.music.createStepTwo', compact('music'));
    }

    public function postCreateStepTwo(Request $request)
    {
        $validatedData = $request->validate([
            'embeded_url' => [
                'required',
                function ($attribute, $value, $fail) {
                    $iframeCount = substr_count($value, '<iframe');
                    if ($iframeCount > 1) {
                        $fail('Only one embedded code is allowed.');
                    } elseif ($iframeCount === 0 || !preg_match('/<iframe.*src=["\'].*["\'].*><\/iframe>/', $value)) {
                        $fail('The embedded code must be a valid iframe.');
                    }
                }
            ],
        ]);
        
        $music = $request->session()->get('music');
        $music['embeded_url'] = $validatedData['embeded_url'];
        $request->session()->put('music', $music);

        return redirect()->route('musician.create.step.three');
    }

    public function createStepThree(Request $request)
    {
        // $genres = Genre::all();
        $genres = Genre::where('parent_id', null)->with('parentGenre')->get();
        $music = $request->session()->get('music');

        return view('musician.music.createStepThree', compact(['music', 'genres']));
    }

    public function postCreateStepThree(Request $request)
    {

        $validatedData = $request->validate([
            'genre' => 'required',
        ]);

        $music = $request->session()->get('music');
        $music['genre'] = $validatedData['genre'];
        $request->session()->put('music', $music);

        return redirect()->route('musician.create.step.four');
    }

    public function createStepFour(Request $request)
    {

        $music = $request->session()->get('music');
        return view('musician.music.createStepFour', compact('music'));
    }

    public function postCreateStepFour(Request $request)
    {
        $request->validate([
            'images' => ['required', 'array', 'min:1'],
            'images.*' => [
                'required',
                'file',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:3000', // 3MB max size
                'dimensions:min_width=300,min_height=300' // Minimum dimensions
            ],
        ], [
            'images.required' => 'At least one image is required.',
            'images.*.image' => 'All uploaded files must be images.',
            'images.*.mimes' => 'Images must be in JPEG, PNG, JPG or GIF format.',
            'images.*.max' => 'Images must not be larger than 3MB.',
            'images.*.dimensions' => 'Images must be at least 300x300 pixels.'
        ]);

        // grab sata in session
        $music = $request->session()->get('music');

        // check for possible music status
        $adminSettings = AdminSetting::where('name', 'autoApproveSong')->first();
        $userMusics = Auth::user()->music->count();
        if ($adminSettings->status == 1) {
            if ($userMusics == 0) {
                $createdMusic = $this->storeMusic($music, 'approve');
            } else {
                $createdMusic = $this->storeMusic($music, 'unpaid');
            }
        } else {
            $createdMusic = $this->storeMusic($music, 'pending');
        }
        // store multiple music Images
        foreach ($request->images as $index => $image) {
            try {
                // Validate image
                if (!$image->isValid()) {
                    throw new \Exception('Invalid image file');
                }

                $maxSize = 3 * 1024 * 1024; // 3MB
                if ($image->getSize() > $maxSize) {
                    // Get image info
                    $source = imagecreatefromstring(file_get_contents($image));
                    $sourceWidth = imagesx($source);
                    $sourceHeight = imagesy($source);
                    
                    // Calculate new dimensions (max 2000px width/height)
                    $maxDimension = 2000;
                    if ($sourceWidth > $maxDimension || $sourceHeight > $maxDimension) {
                        if ($sourceWidth > $sourceHeight) {
                            $newWidth = $maxDimension;
                            $newHeight = ($sourceHeight / $sourceWidth) * $maxDimension;
                        } else {
                            $newHeight = $maxDimension;
                            $newWidth = ($sourceWidth / $sourceHeight) * $maxDimension;
                        }
                        
                        // Create new image
                        $new = imagecreatetruecolor($newWidth, $newHeight);
                        imagecopyresampled($new, $source, 0, 0, 0, 0, $newWidth, $newHeight, $sourceWidth, $sourceHeight);
                        
                        // Create temporary file
                        $tmpFile = tempnam(sys_get_temp_dir(), 'img');
                        imagejpeg($new, $tmpFile, 80);
                        
                        // Free memory
                        imagedestroy($source);
                        imagedestroy($new);
                        
                        // Create new UploadedFile instance
                        $image = new \Illuminate\Http\UploadedFile(
                            $tmpFile,
                            $image->getClientOriginalName(),
                            'image/jpeg',
                            null,
                            true
                        );
                    }
                }

                $photoPath = $this->getImage($image, Music::find($createdMusic->id));
                if ($index == 0) {
                    $createdMusic->image_url = $photoPath;
                    $createdMusic->save();
                } else {
                    DB::table('images_music')->insert([
                        'music_id' => $createdMusic->id,
                        'image_path' => $photoPath,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            } catch (\Exception $e) {
                \Log::error('Image upload error: ' . $e->getMessage());
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['images' => 'Error uploading image: ' . $e->getMessage()]);
            }
        }
        // clear session
        $request->session()->forget('music');

        $adminsetting = AdminSetting::where('name', 'autoApproveSong')->first();
        if ($adminsetting->status) {
            $message = null;
            // emails when the song is first free
            if ($createdMusic->status === 'approve') {
                $this->emailService->send(Auth::user()->email, (new EmailToMusicianWhenSongIsFree())->forUser(Auth::user()), 'music.free', Auth::user());
            } else {
                $this->emailService->send(Auth::user()->email, (new SongApprovalToMusician($createdMusic))->forUser(Auth::user()), 'music.approval', Auth::user());
            }
        } else {
            $message = 'Thank you for submitting your song ' . $createdMusic->title . '. Our admins will review your submission and once it is approved we can get started getting your song heard by our curators!';
            $this->emailService->send(Auth::user()->email, (new EmailToMusicianWhenSongIsSubmited())->forUser(Auth::user()), 'music.submitted', Auth::user());
        }

        $this->emailService->send('admin@youhearus.com', new AdminNotificationOnMusicSubmit(Auth::user()->name), 'admin.notification', null);

        return redirect()->route('musician.index')->with([
            'message' => $message,
            'musicId' => $createdMusic->id
        ]);
    }

    public function show(Music $music)
    {
        return view('musician.music.show', compact('music'));
    }

    public function storeMusic($music, $status){
        // change date format
        $release_date = Carbon::parse($music['release_date']);
        $newDate = $release_date->format('Y-m-d');

        $createdMusic = Music::create([
            'title' => $music['title'],
            'user_id' => Auth::user()->id,
            'release_type' => $music['release_type'],
            'release_date' => $newDate,
            'song_version' => $music['song_version'],
            'description' => $music['description'],
            'embeded_url' => $music['embeded_url'],
            'genre' => json_encode($music['genre']),
            'status' => $status,
            'wait_for_song_release' => $music['wait_for_song_release'],
        ]);

        // check for press realease 
        if(isset($music['release_url'])){
            if (!is_null($music['release_url'])) {

                $disk = Storage::disk('public');
                if ($disk->exists($music['release_url'])) {
                    $explodedtitle = explode(" ", $music['title']);
                    $removeSpecialChar = preg_replace('/[^a-zA-Z0-9]/', '', $explodedtitle);
                    $filteredWords = array_filter($removeSpecialChar, function ($word) {
    
                        $cleanedWord = preg_replace('/[^a-zA-Z0-9]/', '', $word);
                        return !empty($cleanedWord);
                    });
                    $implodedTitle = implode('-', $filteredWords);
                    $newDirectory = 'files/' . $createdMusic->id . '-' . $implodedTitle;

                   
                    $newFilePath = $newDirectory . '/' . basename($music['release_url']);
                    $disk->move($music['release_url'], $newFilePath);
                    
                    $createdMusic->release_url = $newFilePath;
                }
            }


        }else{
            $pressReleaseQuestion = new PressReleaseQuestions();
            $pressReleaseQuestion->music_id = $createdMusic->id;
            $pressReleaseQuestion->Question0 = $music['PressNote0'];
            $pressReleaseQuestion->Question1 = $music['PressNote1'];
            $pressReleaseQuestion->Question2 = $music['PressNote2'];
            $pressReleaseQuestion->Question3 = $music['PressNote3'];
            $pressReleaseQuestion->Question4 = $music['PressNote4'];
            $pressReleaseQuestion->Question5 = $music['PressNote5'];
            $pressReleaseQuestion->Question6 = $music['PressNote6'];
            $pressReleaseQuestion->Question7 = $music['PressNote7'];
            $pressReleaseQuestion->save();
        }

        if(isset($music['note'])){
            $createdMusic->note = $music['note'];
        }

        $createdMusic->save();

        $musicId = Music::find($createdMusic->id);
        $genreIds = $music['genre'];
        $createdMusic->genres()->sync($genreIds);
        return $createdMusic;
    }
}
