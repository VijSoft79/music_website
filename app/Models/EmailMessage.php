<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmailMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'email_type',
        'email_to',
        'content',
    ];

    public function userChosenEmail(): BelongsTo
    {
        return $this->belongsTo(UserChosenEmail::class, 'id', 'id');
    }
}
