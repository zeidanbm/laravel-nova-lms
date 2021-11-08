<?php

namespace App\Observers;

use App\Models\Cover;
use App\Jobs\DeleteImages;
use Illuminate\Support\Facades\Log;

class CoverObserver
{
    /**
     * Handle the Cover "created" event.
     *
     * @param  \App\Models\Cover  $cover
     * @return void
     */
    public function created(Cover $cover)
    {

    }

    /**
     * Handle the Cover "updated" event.
     *
     * @param  \App\Models\Cover  $cover
     * @return void
     */
    public function updated(Cover $cover)
    {
        //
    }

    /**
     * Handle the Cover "deleted" event.
     *
     * @param  \App\Models\Cover  $cover
     * @return void
     */
    public function deleted(Cover $cover)
    {
        DeleteImages::dispatch($cover->details);
    }

    /**
     * Handle the Cover "restored" event.
     *
     * @param  \App\Models\Cover  $cover
     * @return void
     */
    public function restored(Cover $cover)
    {
        //
    }

    /**
     * Handle the Cover "force deleted" event.
     *
     * @param  \App\Models\Cover  $cover
     * @return void
     */
    public function forceDeleted(Cover $cover)
    {
        //
    }
}
