<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'details' => 'array',
    ];
    
    /**
     * Get the owning fileable model.
     */
    public function fileable()
    {
        return $this->morphTo();
	}
}
