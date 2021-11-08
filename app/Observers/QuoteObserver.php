<?php

namespace App\Observers;

use App\Models\Quote;
use App\Jobs\SaveToElastic;
use App\Jobs\DeleteFromElastic;
use Illuminate\Support\Facades\Auth;

class QuoteObserver
{
    /**
     * Handle the Quote "creating" event.
     *
     * @param  \App\Models\Quote  $quote
     * @return void
     */
    public function creating(Quote $quote)
    {
        $quote->user_id = Auth::id();
    }

    /**
     * Handle the Quote "updated" event.
     *
     * @param  \App\Models\Quote  $quote
     * @return void
     */
    public function updated(Quote $quote)
    {
        //
    }
    
    /**
     * Handle the Quote "saved" event.
     *
     * @param  \App\Models\Quote  $quote
     * @return void
     */
    public function saved(Quote $quote)
    {
        SaveToElastic::dispatch(Quote::toElastic($quote));
    }

    /**
     * Handle the Quote "deleted" event.
     *
     * @param  \App\Models\Quote  $quote
     * @return void
     */
    public function deleted(Quote $quote)
    {
        DeleteFromElastic::dispatch($quote->id);
    }

    /**
     * Handle the Quote "restored" event.
     *
     * @param  \App\Models\Quote  $quote
     * @return void
     */
    public function restored(Quote $quote)
    {
        //
    }

    /**
     * Handle the Quote "force deleted" event.
     *
     * @param  \App\Models\Quote  $quote
     * @return void
     */
    public function forceDeleted(Quote $quote)
    {
        //
    }
}
