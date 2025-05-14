<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;

use Spatie\Permission\Traits\HasRoles;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\models\SpotifyToken;

use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'location',
        'phone_number',
        'website',
        'status',
        'location',
        'bio',
        'estimated_visitor',
        'total_reviews',
        'contribution_bio',
        'facebook_link',
        'instagram_link',
        'spotify_link',
        'tiktok_link',
        'youtube_link',
        'soundcloud_link',
        'songkick_link',
        'bandcamp_link',
        'telegram',
        'twitter_link',
        'is_email_enabled',
        'band_name',
    ];

    // protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_email_enabled' => 'boolean',
        ];
    }

    public function OfferTemplate()
    {
        return $this->hasMany(OfferTemplate::class);
    }

    public function Offer()
    {
        return $this->hasMany(Offer::class);
    }

    public function music()
    {
        return $this->hasMany(Music::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function wallet()
    {
        return $this->hasOne(CuratorWallet::class, 'curator_id');
    }

    public function transactions()
    {
        return $this->hasmany(Transaction::class, 'user_id');
    }

    public function paypal()
    {
        return $this->hasOne(CuratorPaypal::class);
    }

    public function wise()
    {
        return $this->hasOne(CuratorWise::class);
    }

    public function special()
    {
        return $this->hasOne(SpecialAccount::class);
    }

    // User model
    public function chosenEmails()
    {
        return $this->hasMany(UserChosenEmail::class);
    }

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class)->withPivot('used_at')->withTimestamps();
    }

    public function spotifyToken()
    {
        return $this->hasOne(SpotifyToken::class);
    }

    // for musician users
    public function getTotalPayment($type)
    {
        if ($this->hasRole('musician')) {
            return Transaction::where('user_id', $this->id)
            ->where('type', $type)
            ->sum('amount');
        }

        return collect(); // Return empty collection if the user doesn't have the role
    }

    // grab the total counts of the musician recieves from a curator
    public function totalOffersToMusician($musicianId, $status)
    {
        if ($this->hasRole('curator')) {
            return \DB::table('offers')
            ->join('music', 'offers.music_id', '=', 'music.id')
            ->where('offers.user_id', $this->id) // Offers made by this curator
            ->where('music.user_id', $musicianId) // Music belongs to this musician
            ->where('offers.status', $status) // Only accepted offers
            ->count();
        }
        
        return collect();
    }

    // check if the user wants to receive emails
    public function wantsToReceiveEmails(): bool
    {
        return $this->is_email_enabled;
    }

    public function unsubscribeFromEmails(): void
    {
        $this->is_email_enabled = false;
        $this->save();
    }

    public function subscribeToEmails(): void
    {
        $this->is_email_enabled = true;
        $this->save();
    }

}
