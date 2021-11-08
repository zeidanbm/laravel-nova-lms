<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Elasticsearch\Client;
use Illuminate\Http\Request;
use App\Http\Requests\BookRequest;
use App\Http\Controllers\BaseController;

class BookController extends BaseController
{
  /**
   * @var string
   */
  private $slug;

  public function __construct(Request $request) {
    $this->slug = ltrim($request->slug);
	}
	
  /**
 * Get the unique book using slug
 *
 * @return \Illuminate\Http\Response
 */
  public function findBySlug()
  {
    $book = Book::with([
        'authors', 'publishers', 'sources',
        'tags', 'topic', 'subtopic', 'cover'
    ])
    ->where('slug', $this->slug)
    ->firstOrFail();
    
    return $this->sendSuccess(
        'Book retrieved successfully.',
        [
            'data' => $this->parseResults($book)
        ]
    );
  }
  
  private function parseResults($book)
    {
      $cover = optional($book->cover)->details;
      return [
          'id' => $book->id,
          'title' => $book->title,
          'sub_title' => $book->sub_title,
          'slug' => $book->slug,
          'type' => $book->getType(),
          'topic' => optional($book->topic)->name,
          'subtopic' => optional($book->subtopic)->name,
          'body' => $book->body,
          'cover_thumbnail' => $cover ? $cover['thumbnail'] : NULL,
          'cover_medium' => $cover ? $cover['medium'] : NULL,
          'cover_large' => $cover ? $cover['large'] : NULL,
          'authors' => optional($book->authors)->pluck('name'),
          'publishers' => optional($book->publishers)->pluck('name'),
          'tags' => optional($book->tags)->pluck('name')
      ];
    }
}
