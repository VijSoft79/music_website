<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuratorPaypal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'paypal_address'
    ];

    public function user(){
        return $this->hasOne(User::class);
    }
}
