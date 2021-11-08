<?php

namespace App\Observers;

use App\Jobs\DeleteFromElastic;
use App\Models\Book;
use App\Jobs\SaveToElastic;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class BookObserver
{
    /**
     * Handle the Book "creating" event.
     *
     * @param  \App\Models\Book  $book
     * @return void
     */
    public function creating(Book $book)
    {
        $book->user_id = Auth::id();
    }
    
    /**
     * Handle the Book "created" event.
     *
     * @param  \App\Models\Book  $book
     * @return void
     */
    public function created(Book $book)
    {
        
    }
    
    /**
     * Handle the Book "updating" event.
     *
     * @param  \App\Models\Book  $book
     * @return void
     */
    public function updating(Book $book)
    {
        if($book->details['no_author']) {
            $book->authors()->detach();
        }
        
        if($book->details['no_source']) {
            $book->sources()->detach();
        }
        
        if($book->details['no_publisher']) {
            $book->publishers()->detach();
        }
    }
    
    /**
     * Handle the Book "saved" event.
     *
     * @param  \App\Models\Book  $book
     * @return void
     */
    public function saving(Book $book)
    {
        $book->sub_title = $book->details['no_sub_title'] ? NULL : $book->sub_title;
        $book->acquisition_year = $book->details['no_acquisition_year'] ? NULL : $book->acquisition_year;
        $book->isbn = $book->details['no_isbn'] ? NULL : $book->isbn;
        $book->publishing_location = $book->details['no_publishing_location'] ? NULL : $book->publishing_location;
        $book->publishing_year = $book->details['no_publishing_year'] ? NULL : $book->publishing_year;
    }


    /**
     * Handle the Book "saved" event.
     *
     * @param  \App\Models\Book  $book
     * @return void
     */
    public function saved(Book $book)
    {
        SaveToElastic::dispatch(Book::toElastic($book));
    }

    /**
     * Handle the Book "deleted" event.
     *
     * @param  \App\Models\Book  $book
     * @return void
     */
    public function deleted(Book $book)
    {
        DeleteFromElastic::dispatch($book->id);
    }

    /**
     * Handle the Book "restored" event.
     *
     * @param  \App\Models\Book  $book
     * @return void
     */
    public function restored(Book $book)
    {
        //
    }

    /**
     * Handle the Book "force deleted" event.
     *
     * @param  \App\Models\Book  $book
     * @return void
     */
    public function forceDeleted(Book $book)
    {
        //
    }
}
