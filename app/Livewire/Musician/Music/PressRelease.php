<?php

namespace App\Livewire\Musician\Music;

use App\Models\PressReleaseQuestions;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\Music;
use Schema;
use Str;

class PressRelease extends Component
{
    use WithFileUploads;

    public $music;
    public $pressRelease = true; // Toggle switch
    public $releaseFile;
    public $pressQuestions = [];
    public $message ='';

    protected $rules = [
        'releaseFile' => 'nullable|file|mimes:pdf,txt|max:2048',
        'pressQuestions' => 'nullable|array',
        'pressQuestions.*' => 'nullable|string|max:1000',
    ];

    public function mount(Music $music)
    {
        $this->music = $music;
        $this->pressQuestions = $music->press_questions ?? [];
        $this->pressRelease = empty($music->release_url);
    }


    public function savePressRelease()
    {
        $this->validate();
        
        // validate the input
        if ($this->releaseFile) {
            $music = implode('-', explode(' ', $this->music->title));

            $folderName = 'files/' . $this->music->id . '-' . $music;
            $fileName = Str::random(40). '.' . $this->releaseFile->getClientOriginalExtension();
            $disk = Storage::disk('public');
            
            //if path exist already
            if ($disk->exists($folderName)) {
                $path = $this->releaseFile->storeAs($folderName, $fileName, 'public');
                
                $this->music->release_url = $path;
                $this->music->save();

            // if not exist create a dir and save    
            }else {

                $disk->makeDirectory($folderName);
                $path = $this->releaseFile->storeAs($folderName, $fileName, 'public');

                $this->music->release_url = $path;
                $this->music->save();
            }

            return;
        }


        if ($this->pressQuestions) {

            if (count($this->pressQuestions) !== 8) {
                session()->flash('message', 'You must provide exactly 7 press questions.');
                return; 
            }
  
            PressReleaseQuestions::create([
                'music_id' => $this->music->id,
                'question0' => $this->pressQuestions[0],
                'question1' => $this->pressQuestions[1],
                'question2' => $this->pressQuestions[2],
                'question3' => $this->pressQuestions[3],
                'question4' => $this->pressQuestions[4],
                'question5' => $this->pressQuestions[5],
                'question6' => $this->pressQuestions[6],
                'question7' => $this->pressQuestions[7],
            ]);
      
        }else {
            session()->flash('message', 'Please Upload Inputs or Complete the Questions');
        }
        

        session()->flash('message', 'Press release updated successfully!');
    }

    public function render()
    {
        return view('livewire.musician.music.press-release');
    }
}
