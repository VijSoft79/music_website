<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'coupon_code',
        'expire_date',
        'discount_amount',
    ];

    // public function coupon()
    // {
    //     return $this->belongsTo(Coupon::class);
    // }
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('used_at')->withTimestamps();
    }

}
