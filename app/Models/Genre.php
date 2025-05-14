<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Genre extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        "name",
        "parent_id"
    ];

    
    protected $dates = [
        'deleted_at'
    ];

    
    public function music(){
        return $this->belongsToMany(Music::class);
    }

    public function parentGenre()
    {
        return $this->belongsTo(Genre::class, 'parent_id');
    }

    public function childGenres()
    {
        return $this->hasMany(Genre::class, 'parent_id');
    }

    public function user()
    {
        return $this->belongsToMany(User::class);
    }

}
