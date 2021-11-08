<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quote extends Model
{
    use HasFactory;
    
     /**
     * Get the author associated with the quote.
     */
    public function author()
    {
        return $this->belongsTo('App\Models\Author');
    }
    
    /**
     * Get the User that owns the quote.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
		}
    
  /**
	 * Create a new results Array.
	 *
	 * @param  collection  $model
	 * @return array
	 */
	public static function toElastic($model)
	{	
		$author = optional($model->author)->name;
		
		return [
			'suggest' => [
				$model->body,
				$author
			],
			'model_id' => $model->id,
			'type' => 'Quote',
			'authors' => $author,
			'body' => $model->body,
			'status' => $model->status,
			'created_at' => optional($model->created_at)->toDateTimeString()
		];
	}
}
