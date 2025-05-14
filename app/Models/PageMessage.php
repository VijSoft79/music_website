<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'page',
        'content',
    ];
}
