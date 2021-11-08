<?php

namespace App\Observers;

use App\Models\Publication;
use Illuminate\Support\Facades\Auth;

class PublicationObserver
{
    /**
     * Handle the Publication "creating" event.
     *
     * @param  \App\Models\Publication  $publication
     * @return void
     */
    public function creating(Publication $publication)
    {
        $publication->user_id = Auth::id();
    }

    /**
     * Handle the Publication "updated" event.
     *
     * @param  \App\Models\Publication  $publication
     * @return void
     */
    public function updated(Publication $publication)
    {
        //
    }

    /**
     * Handle the Publication "deleted" event.
     *
     * @param  \App\Models\Publication  $publication
     * @return void
     */
    public function deleted(Publication $publication)
    {
        //
    }

    /**
     * Handle the Publication "restored" event.
     *
     * @param  \App\Models\Publication  $publication
     * @return void
     */
    public function restored(Publication $publication)
    {
        //
    }

    /**
     * Handle the Publication "force deleted" event.
     *
     * @param  \App\Models\Publication  $publication
     * @return void
     */
    public function forceDeleted(Publication $publication)
    {
        //
    }
}
