<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfferTemplate extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'is_active',
        'status',
        'has_premium',
        'is_disabled'
    ];

    public function offer(){
        return $this->hasMany(Offer::class, 'offer_template_id');
    }

    public function curator(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function basicOffer(){
        return $this->hasOne(BasicOffer::class);
    }

    public function premiumOffer(){
        return $this->hasOne(PremiumOffer::class);
    }

    public function freeAlternative(){
        return $this->hasOne(FreeAlternative::class);
    }

    public function spotifyPlayList(){
        return $this->hasOne(SpotifyPlaylist::class);
    }
}
