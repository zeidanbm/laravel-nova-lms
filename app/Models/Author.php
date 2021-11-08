<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
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
     * Get the quotes associated with the author.
     */
    public function quotes()
    {
        return $this->hasMany('App\Models\Quote');
    }
    
    /**
     * The books that belong to the author.
     */
    public function books()
    {
        return $this->belongsToMany('App\Models\Book', 'book_author');
    }
}
