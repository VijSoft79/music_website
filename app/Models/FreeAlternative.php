<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreeAlternative extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'offer_template_id',
        'alter_description',
        'alter_url',
    ];

    public function offertemplate(){
        return $this->belongTo(OfferTemplate::class);
    }
}
