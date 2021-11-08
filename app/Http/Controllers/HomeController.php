<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthManager;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\BaseController;

class HomeController extends BaseController
{
    public function __construct(AuthManager $auth)
    {
        parent::__construct($auth);
    }
    
    public function getOwnedCatalogs($request)
    {
        $per_page = $request->per_page ?? 15;

        $books = Book::isOwned()
                    ->paginate($per_page);
        
        return $this->sendSuccess(
            'Owned catalogs retrieved successfully.',
            [
                'data' => $this->parseResults($books)
            ]
        );
    }
  
    public function getFeaturedCatalogs($request)
    {
        $per_page = $request->per_page ?? 15;

        $books = Book::isFeatured()
                    ->paginate($per_page);
        
        return $this->sendSuccess(
            'Featured catalogs retrieved successfully.',
            [
                'data' => $this->parseResults($books)
            ]
        );
    }
    
    private function parseResults($books)
    {
        return $books->getCollection()->transform(function($item, $key)
            {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'slug' => $item->slug,
                    'cover_thumbnail' => optional($item->cover)->details['thumbnail']
                ];
            }
        );
    }
}
