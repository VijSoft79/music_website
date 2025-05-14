<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'is_special'
    ];

    public function user(){
        return $this->belongTo(User::class);
    }
}
