<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvitationForChecking extends Model
{
    use HasFactory;

    protected $table = 'invitations_for_checking';

    protected $fillable = [
        'offer_id',
        'status',
        'url',
        'images',
    ];

    public function offer(){
        return $this->belongsTo(Offer::class, 'offer_id');
    }
}
