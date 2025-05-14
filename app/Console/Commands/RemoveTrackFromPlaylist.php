<?php

namespace App\Console\Commands;

use App\Mail\EmailToMusicianWhenMusicExpires;
use App\Models\SpotifyTrack;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Services\EmailService;


class RemoveTrackFromPlaylist extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:remove-track';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    
    public function handle()
    {
        $currentDate = Carbon::today()->format('Y-m-d');
        $expiredTracks = SpotifyTrack::all();
        
        foreach ($expiredTracks as $expiredTrack) {
            // echo $expiredTrack->id;

            $playlistId = $expiredTrack->playlist_id;
            $trackId = $expiredTrack->track_id;
            $spotifyToken = $expiredTrack->spotifyToken->access_token;
            $userMail = $expiredTrack->music->artist->email;


            if ($expiredTrack->expiration_date == $currentDate) {
                
                $url = "https://api.spotify.com/v1/playlists/$playlistId/tracks";
                $data = [
                    'tracks' => [
                        [
                            'uri' => "spotify:track:$trackId"
                        ]
                    ]
                ];

                $response = Http::withToken($spotifyToken)->delete($url, $data);

                if ($response->successful()) {
                    
                    $update = SpotifyTrack::find($expiredTrack->id);
                    $update->status = false; //deleted
                    $update->save();

                    echo $this->info('Track removed successfully!');
                    if ($expiredTrack->music_id) {
                        $emailService = app(EmailService::class);
                        $user = $expiredTrack->music->artist;
                        $emailService->send($userMail, 
                            (new EmailToMusicianWhenMusicExpires($expiredTrack->music->artist->name, $expiredTrack->music->title))->forUser($user),
                            'music.expired', 
                            $user);
                    }
                    
                } else {
                    echo $this->error('Failed to remove track.');
                }
            }
            
           
            
        }
        

      
    }
}
