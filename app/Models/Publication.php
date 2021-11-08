<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'from_date' => 'date:Y-m',
        'to_date' => 'date:Y-m'
    ];
    
    /**
     * Get the book's cover image.
     */
    public function cover()
    {
        return $this->morphOne('App\Models\Cover', 'coverable');
    }
    
    /**
     * Get the book's file image.
     */
    public function file()
    {
        return $this->morphOne('App\Models\File', 'fileable');
    }
    
    /**
     * Get the periodic that owns the publication.
     */
    public function periodic()
    {
        return $this->belongsTo('App\Models\Periodic');
    }
    
    /**
     * Get the User that owns the publication.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
