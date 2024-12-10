<?php

namespace App\Observers;

use App\Models\Carrier;

class CarrierObserver
{
    /**
     * Håndterer oprettelsen af en Incident og opdaterer Carrier status.
     *
     * @param  \App\Models\Incident  $incident
     * @return void
     */
    public function created(Incident $incident)
    {
        $incident->carrier->updateStatus();
    }

    /**
     * Håndterer opdatering af en Incident og opdaterer Carrier status.
     *
     * @param  \App\Models\Incident  $incident
     * @return void
     */
    public function updated(Incident $incident)
    {
        $incident->carrier->updateStatus();
    }

    /**
     * Håndterer sletning af en Incident og opdaterer Carrier status.
     *
     * @param  \App\Models\Incident  $incident
     * @return void
     */
    public function deleted(Incident $incident)
    {
        if ($incident->carrier->incidents->where('status', 'active')->count() == 0) {
            $incident->carrier->status = 'green';
            $incident->carrier->save();
        }
    }

    /**
     * Handle the Carrier "restored" event.
     */
    public function restored(Carrier $carrier): void
    {
        //
    }

    /**
     * Handle the Carrier "force deleted" event.
     */
    public function forceDeleted(Carrier $carrier): void
    {
        //
    }
}
