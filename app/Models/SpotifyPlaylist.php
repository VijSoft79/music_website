<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpotifyPlaylist extends Model
{
    use HasFactory;

    protected $fillable = [
        'offer_template_id',
        'playlist_name',
        'playlist_url', 
        'song_position',
        'days_of_display', 
        'description'
    ];

    public function OfferTemplate(){
        return $this->hasOne(OfferTemplate::class);
    }


}
