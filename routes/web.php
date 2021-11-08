<?php

use App\Models\Book;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// todo: substitute the routes below with wild card route
Route::get('/', App\Http\Controllers\PagesController::class);
Route::get('/search', App\Http\Controllers\PagesController::class);
Route::get('/book/{book}', App\Http\Controllers\PagesController::class);

// Route::bind('book', function($slug) {
//     return Book::with([
//         'authors', 'publishers', 'sources',
//         'tags', 'topic', 'subtopic', 'cover'
//     ])->where('slug', $slug)->firstOrFail();
// });
// Route::get('/book/{book}', 'App\Http\Controllers\BookController@show');
