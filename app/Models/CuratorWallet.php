<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuratorWallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'curator_id',
        'amount',
    ];

    public function curator(){
        return $this->belongsTo(User::class);
    }
}
