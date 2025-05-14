<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Music;

class RemoveMUsicWithNoArtist extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clean-music';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public $noArtist = [];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $musics = Music::all();

        foreach($musics as $music){
            if($music->artist == null){
                $this->noArtist[] = $music->title;
                $music->delete();
                echo $music->title . "\n";
            }
        }
    }
}
