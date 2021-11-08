<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;
    
    /**
     * Get the subtopics associated with the topic.
     */
    public function subtopics()
    {
        return $this->hasMany('App\Models\Subtopic');
    }
    
    /**
     * Get the books for the topic
     */
    public function books()
    {
        return $this->hasMany('App\Models\Book');
    }
}
