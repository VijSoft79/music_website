<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpotifyTrack extends Model
{
    use HasFactory;

    protected $fillable = [
        'spotify_token_id',
        'track_id',
        'playlist_id',
        'expiration_date',
        'status',
        'music_id',
    ];

    public function spotifyToken()
    {
        return $this->belongsTo(SpotifyToken::class);
    }
    public function music()
    {
        return $this->belongsTo(Music::class);
    }
    
}
