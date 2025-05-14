<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory, HasSlug;
    
    protected $fillable = [
        'user_id',
        'title',
        'content'
    ];

        /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function category(){
        return $this->belongsToMany(Category::class);
    }

    public function exerpt()
    {
        return Str::words(strip_tags($this->content), 20);
    }
}
