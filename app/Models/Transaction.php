<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'amount',
        'type',
        'status',
        'music_id',
        'transaction_fee',
        'offer_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function music()
    {
        return $this->belongsTo(Music::class);
    }

    public function invitation()
    {
        return $this->belongsTo(Offer::class, 'offer_id');
    }

}
