<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasicOffer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'offer_type',
        'description',
        'offer_price',
        'introduction',
        
    ];

    public function offer_template()
    {
        return $this->belongsTo(OfferTemplate::class, 'offer_template_id');
    }
}
