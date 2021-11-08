<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cover extends Model
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
     * Get the owning coverable model.
     */
    public function coverable()
    {
        return $this->morphTo();
	}
}
