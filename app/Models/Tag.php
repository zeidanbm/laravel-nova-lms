<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory, HasSlug;
    
    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
                        ->generateSlugsFrom('name')
                        ->saveSlugsTo('slug')
                        ->usingLanguage('ar');
    }
    
    /**
     * The books that belong to the tag.
     */
    public function books()
    {
        return $this->belongsToMany('App\Models\Book');
    }
}
