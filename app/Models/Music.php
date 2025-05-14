<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Music extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'user_id',
        'release_date',
        'release_type',
        'song_version',
        'note',
        'description',
        'embeded_url',
        'genre',
        'status',
        'image_url',
        'release_url',
        'wait_for_song_release'
    ];

    public function offers()
    {
        // return $this->belongsToMany(Offer::class);
        return $this->hasMany(Offer::class);
        // return $this->belongsToMany(Offer::class, 'music_offer')
        //             ->withPivot('status');
    }

    public function artist()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }

    public function images()
    {
        return DB::table('images_music')
                 ->where('music_id', $this->id)
                 ->get(['image_path']);
    }

    public function remainingDays()
    {
        $createdAt = Carbon::parse($this->created_at);
        $now = Carbon::now();
        $daysDifference = $createdAt->diffInDays($now);
        $remainingDays = 90 - $daysDifference;
        return max(0, $remainingDays);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function coupon(){
        return $this->hasOne(Coupon::class);
    }

    public function pressQuestion() : HasOne
    {
        return $this->hasOne(PressReleaseQuestions::class);
    }

    /**
     * Get the user-friendly download filename for the press release.
     *
     * @return string|null
     */
    public function getPressReleaseDownloadFilenameAttribute(): ?string
    {
        if (!$this->release_url) {
            return null;
        }

        $extension = pathinfo($this->release_url, PATHINFO_EXTENSION);
        // Ensure the artist relationship is loaded or use a default
        $artistNameSlug = Str::slug($this->artist->name ?? 'unknown-artist');
        $musicTitleSlug = Str::slug($this->title ?? 'untitled');

        return "{$artistNameSlug}_{$musicTitleSlug}_press-release.{$extension}";
    }

    /**
     * Get the user-friendly fallback download filename (as .txt) for the press release.
     *
     * @return string|null
     */
    public function getPressReleaseFallbackFilenameAttribute(): ?string
    {
        // Ensure the artist relationship is loaded or use a default
        $artistNameSlug = Str::slug($this->artist->name ?? 'unknown-artist');
        $musicTitleSlug = Str::slug($this->title ?? 'untitled');

        return "{$artistNameSlug}_{$musicTitleSlug}_press-release.txt";
    }
}
