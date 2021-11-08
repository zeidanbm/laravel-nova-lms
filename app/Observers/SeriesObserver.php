<?php

namespace App\Observers;

use App\Models\Series;
use Illuminate\Support\Facades\Auth;

class SeriesObserver
{
    /**
     * Handle the Series "creating" event.
     *
     * @param  \App\Models\Series  $series
     * @return void
     */
    public function creating(Series $series)
    {
        $series->user_id = Auth::id();
    }

    /**
     * Handle the Series "updated" event.
     *
     * @param  \App\Models\Series  $series
     * @return void
     */
    public function updated(Series $series)
    {
        //
    }

    /**
     * Handle the Series "deleted" event.
     *
     * @param  \App\Models\Series  $series
     * @return void
     */
    public function deleted(Series $series)
    {
        //
    }

    /**
     * Handle the Series "restored" event.
     *
     * @param  \App\Models\Series  $series
     * @return void
     */
    public function restored(Series $series)
    {
        //
    }

    /**
     * Handle the Series "force deleted" event.
     *
     * @param  \App\Models\Series  $series
     * @return void
     */
    public function forceDeleted(Series $series)
    {
        //
    }
}
