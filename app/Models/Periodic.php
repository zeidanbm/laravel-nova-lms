<?php

namespace App\Models;

use Carbon\Carbon;
use App\Options\Format;
use Illuminate\Support\Str;
use App\Options\PeriodicType;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Periodic extends Model
{
    use HasFactory, HasSlug;
    
    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->usingLanguage('ar');
    }
    
    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
    
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'details' => 'array',
    ];
    
    /**
     * The sources that belong to the periodic.
     */
    public function sources()
    {
        return $this->belongsToMany('App\Models\Source');
    }
    
    /**
     * The publishers that belong to the periodic.
     */
    public function publishers()
    {
        return $this->belongsToMany('App\Models\Publisher');
    }
    
    /**
     * Get the periodic's cover image.
     */
    public function cover()
    {
        return $this->morphOne('App\Models\Cover', 'coverable');
    }
    
    /**
     * Get the publications for the periodic.
     */
    public function publications()
    {
        return $this->hasMany('App\Models\Publication');
    }
    
    /**
     * Get the User that owns the periodic.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    
    /**
     * Get the periodic type.
     */
    public function getType()
    {
        return PeriodicType::get()[$this->type_id];
    }
    
    /**
	 * Create a new results Array.
	 *
	 * @param  collection  $model
	 * @return array
	 */
	public static function toElastic($model)
	{	
        $details = optional($model->cover)->details;
        App::setLocale('en');
		
		return [
			'suggest' => [
				$model->title
			],
			'model_id' => $model->id,
			'type' => PeriodicType::get()[$model->type_id],
			'format' => Format::get()[$model->format_id],
			'series_id' => $model->series_id,
			'title' => $model->title,
			'publishers' => optional($model->publishers)->pluck('name')->toArray(),
			'sources' => optional($model->sources)->pluck('name')->toArray(),
			'publication_ids' => optional($model->publications)->pluck('id')->toArray(),
			'body' => $model->body,
			'details' => json_encode($model->details),
            'cover_thumbnail' => $details ? $details['thumbnail'] : NULL,
            'cover_medium' => $details ? $details['medium'] : NULL,
            'cover_large' => $details ? $details['large'] : NULL,
            'slug' => $model->slug,
			'status' => $model->status,
			'created_at' => optional($model->created_at)->toDateTimeString()
		];
	}
}
