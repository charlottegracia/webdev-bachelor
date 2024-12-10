<?php

namespace App\Observers;

use App\Models\Carrier;

class CarrierObserver
{
    
    public function created(Service $service): void
    {
        //
    }

    public function updated(Service $service): void
    {
        //
    }

    public function deleted(Service $service): void
    {
        //
    }

    /**
     * Handle the Carrier "restored" event.
     */
    public function restored(Service $service): void
    {
        //
    }

    /**
     * Handle the Carrier "force deleted" event.
     */
    public function forceDeleted(Service $service): void
    {
        //
    }
}