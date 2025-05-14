<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MarketingSpend extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'offertemplate_id',
        'name',
        'offer_type',
        'description',
        'price',
    ];

    public function offerTemplates(){
        return $this->belongsTo(OfferTemplate::class, 'offertemplate_id');
    }
}
