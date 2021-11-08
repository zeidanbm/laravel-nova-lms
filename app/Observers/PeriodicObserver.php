<?php

namespace App\Observers;

use App\Models\Periodic;
use App\Jobs\SaveToElastic;
use App\Jobs\DeleteFromElastic;
use Illuminate\Support\Facades\Auth;

class PeriodicObserver
{
    /**
     * Handle the Periodic "creating" event.
     *
     * @param  \App\Models\Periodic  $periodic
     * @return void
     */
    public function creating(Periodic $periodic)
    {
        $periodic->user_id = Auth::id();
    }
    
    /**
     * Handle the Periodic "updated" event.
     *
     * @param  \App\Models\Periodic  $periodic
     * @return void
     */
    public function updated(Periodic $periodic)
    {   
        //
    }
    
    /**
     * Handle the Periodic "updating" event.
     *
     * @param  \App\Models\Periodic  $periodic
     * @return void
     */
    public function updating(Periodic $periodic)
    { 
        if($periodic->details['no_source']) {
            $periodic->sources()->detach();
        }
        
        if($periodic->details['no_publisher']) {
            $periodic->publishers()->detach();
        }
    }
    
    /**
     * Handle the Periodic "saved" event.
     *
     * @param  \App\Models\Periodic  $periodic
     * @return void
     */
    public function saving(Periodic $periodic)
    {
        $periodic->acquisition_year = $periodic->details['no_acquisition_year'] ? NULL : $periodic->acquisition_year;
        $periodic->issn = $periodic->details['no_issn'] ? NULL : $periodic->issn;
        $periodic->publishing_location = $periodic->details['no_publishing_location'] ? NULL : $periodic->publishing_location;
    }
    
    /**
     * Handle the Periodic "saved" event.
     *
     * @param  \App\Models\Periodic  $periodic
     * @return void
     */
    public function saved(Periodic $periodic)
    {
        SaveToElastic::dispatch(Periodic::toElastic($periodic));
    }
    
    /**
     * Handle the Periodic "deleted" event.
     *
     * @param  \App\Models\Periodic  $periodic
     * @return void
     */
    public function deleted(Periodic $periodic)
    {
         DeleteFromElastic::dispatch($periodic->id);
    }

    /**
     * Handle the Periodic "restored" event.
     *
     * @param  \App\Models\Periodic  $periodic
     * @return void
     */
    public function restored(Periodic $periodic)
    {
        //
    }

    /**
     * Handle the Periodic "force deleted" event.
     *
     * @param  \App\Models\Periodic  $periodic
     * @return void
     */
    public function forceDeleted(Periodic $periodic)
    {
        //
    }
}
