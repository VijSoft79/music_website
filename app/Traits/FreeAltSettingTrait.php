<?php
namespace App\Traits;
use App\Models\FreeAlternative;
use App\Models\SpotifyPlaylist;
use App\Models\OfferTemplate;

trait FreeAltSettingTrait
{
    public function FreeAltRestriction(array $data, $spotify, $OfferId){

        // dd($data);
        
        
        if (!$spotify) {
             // save free alternatives here
            $freeAlter = new FreeAlternative;
            //  dd($freeAlter);
            $freeAlter->type = $data['alternative_name'];
            $freeAlter->alter_description = $data['alternative_description'];
            $freeAlter->alter_url = $data['alternative_link'];
            $freeAlter->offer_template_id = $OfferId;
            $freeAlter->save();
        }
        else{
            //save spotify playlist here
            $spotifyPlayList = new SpotifyPlaylist;
            $spotifyPlayList->offer_template_id = $OfferId;
            $spotifyPlayList->playlist_name = $data['playlist_name'];
            $spotifyPlayList->playlist_url = $data['playlist_url'];
            $spotifyPlayList->song_position = $data['song_position'];
            $spotifyPlayList->days_of_display = $data['days_of_display'];
            $spotifyPlayList->description = $data['spotify_description'];
            $spotifyPlayList->save();
        }

    }
}