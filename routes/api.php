<?php

use Illuminate\Http\Request;
use App\Http\Requests\BookRequest;
use App\Http\Requests\SearchRequest;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Requests\AutocompleteRequest;
use App\Http\Controllers\AutocompleteController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/owned-catalogs', function (Request $request, HomeController $home) {

	return $home->getOwnedCatalogs($request);
});

Route::get('/featured-catalogs', function (Request $request, HomeController $home) {

	return $home->getFeaturedCatalogs($request);
});

Route::get('/autocomplete', function (AutocompleteController $auto) {

	return $auto->autocomplete();
});

Route::get('/search', function (SearchRequest $request, SearchController $search) {

	return $search->search($request);
});

Route::get('/book', function (BookRequest $request, BookController $book) {

	return $book->findBySlug();
});