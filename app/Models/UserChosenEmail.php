<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserChosenEmail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'chosen_emails'
    ];

    protected $casts = [
        'chosen_emails' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // // Retrieve email messages based on the chosen_emails IDs
    // public function getEmailMessagesAttribute()
    // {
    //     $email = EmailMessage::whereIn('id', $this->chosen_emails)->get();
    //     if($email){

    //     }
        
    //     return EmailMessage::whereIn('id', $this->chosen_emails)->get();
    // }
}
