<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subtopic extends Model
{
    use HasFactory;
    
    /**
     * Get the topic associated with the subtopic.
     */
    public function topic()
    {
        return $this->belongsTo('App\Models\Topic');
    }
    
    /**
     * Get the books for the subtopic
     */
    public function books()
    {
        return $this->hasMany('App\Models\Book');
    }
}
