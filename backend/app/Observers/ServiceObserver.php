<?php

namespace App\Observers;

use App\Models\Service;

class ServiceObserver
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
     * Handle the Service "restored" event.
     */
    public function restored(Service $service): void
    {
        //
    }

    /**
     * Handle the Service "force deleted" event.
     */
    public function forceDeleted(Service $service): void
    {
        //
    }
}