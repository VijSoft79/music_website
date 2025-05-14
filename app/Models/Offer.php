<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'offer_template_id',
        'music_id',
        'status',
        'marketing_spend_option',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function offerTemplate()
    {
        return $this->belongsTo(OfferTemplate::class);
    }

    public function music()
    {
        return $this->belongsTo(Music::class);
        // return self::with('music')->get();
    }

    public function report(){
        return $this->hasOne(InvitationForChecking::class);
    }

    public function transaction(){
        return $this->hasMany(Transaction::class);
    }

    public function findTemplate($type, $id)
    {
        $template = '';

        switch ($type) {
            case 'premium':
                $template = PremiumOffer::find($id);
                break;

            case 'standard':
                $template = BasicOffer::find($id);
                break;

            case 'spotify-playlist':
            case 'spotify-playlists':
                $template = SpotifyPlaylist::find($id);
                break;

            default:
                $template = FreeAlternative::find($id);
                break;
        }

        return $template; // This will never be executed unless you remove dd()
    }

    public static function getInvitationcount($status = null, $conditions = [], $notExpired = false)
    {
        $query = self::where('user_id', auth()->id())
            ->whereHas('music', function ($query) {
                $query->whereNull('deleted_at');
            });

        // Only filter out reports for non-completed status
        if($status != 2) {
            $query->doesntHave('report');
        }

        if(isset($status)){
            $query->where('status', $status);
        }

        if ($notExpired) {
            $query->where('expires_at', '>=', now());
        }

        $query->where($conditions);

        return $query->count();
    }

    public static function hasLateInvitations()
    {
        return self::where('user_id', auth()->id())
            ->where('status', 1) // In progress
            ->where('date_complete', '<', now())
            ->whereHas('music', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->doesntHave('report')
            ->exists();
    }

    public static function getLateInvitations()
    {
        return self::where('user_id', auth()->id())
            ->where('status', 1) // In progress
            ->where('date_complete', '<', now())
            ->whereHas('music', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->doesntHave('report')
            ->orderBy('date_complete', 'asc')
            ->get();
    }

    public static function getActiveInvitations()
    {
        return self::where('user_id', auth()->id())
            ->where('status', 1) // In progress
            ->where('date_complete', '>=', now())
            ->whereHas('music', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->doesntHave('report')
            ->orderBy('date_complete', 'asc')
            ->get();
    }
}
