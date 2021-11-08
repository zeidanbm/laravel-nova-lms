<?php

namespace App\Models;

use Carbon\Carbon;
use App\Options\Format;
use App\Options\BookType;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
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
        'details' => 'array'
    ];
    
    /**
     * The sources that belong to the book.
     */
    public function sources()
    {
        return $this->belongsToMany('App\Models\Source');
    }
    
    /**
     * The publishers that belong to the book.
     */
    public function publishers()
    {
        return $this->belongsToMany('App\Models\Publisher');
    }
    
    /**
     * The authors that belong to the book.
     */
    public function authors()
    {
        return $this->belongsToMany('App\Models\Author', 'book_author');
    }
    
    /**
     * The tags that belong to the book.
     */
    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag');
    }
    
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
     * Get the topic that owns the book.
     */
    public function topic()
    {
        return $this->belongsTo('App\Models\Topic');
    }
    
    /**
     * Get the User that owns the book.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    
    /**
     * Get the subtopic that owns the book.
     */
    public function subtopic()
    {
        return $this->belongsTo('App\Models\Subtopic');
    }
    
    /**
     * Get the series that owns the book.
     */
    public function series()
    {
        return $this->belongsTo('App\Models\Series');
    }
    
    /**
     * Get the book type.
     */
    public function getType()
    {
        return BookType::get()[$this->type_id];
    }
 
    public function scopeIsOwned($query)
    {
        return $query->select('id', 'title', 'slug')
                    ->with(['cover:coverable_id,details'])
                    ->where('is_owned', 1);
    }
    
    public function scopeIsFeatured($query)
    {
        return $query->select('id', 'title', 'slug')
                    ->with(['cover:coverable_id,details'])
                    ->where('is_chosen', 1);
    }

    /**
	 * Create a new results Array.
	 *
	 * @param  collection  $model
	 * @return array
	 */
	public static function toElastic($model)
	{	
        $authors = $model->authors->pluck('name')->toArray();
        $details = optional($model->cover)->details;
        App::setLocale('en');
		
		return [
			'suggest' => array_merge($authors, [
				$model->title,
			]),
			'model_id' => $model->id,
			'type' => BookType::get()[$model->type_id],
			'format' => Format::get()[$model->format_id],
			'series_id' => $model->series_id,
			'title' => $model->title,
			'sub_title' => $model->sub_title,
			'series_title' => optional($model->series)->title,
			'topic' => optional($model->topic)->name,
			'subtopic' => optional($model->subtopic)->name,
			'authors' => $authors,
			'publishers' =>$model->publishers->pluck('name')->toArray(),
			'sources' => $model->sources->pluck('name')->toArray(),
			'tags' => $model->tags->pluck('name')->toArray(),
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
