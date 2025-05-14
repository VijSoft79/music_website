<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PressReleaseQuestions extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'music_id',
        'question0',
        'question1',
        'question2',
        'question3',
        'question4',
        'question5',
        'question6',
        'question7',
    ];

    public function music(): BelongsTo
    {
        return $this->belongsTo(Music::class);
    }
}
