<?php

namespace App\Observers;

use App\Models\Incident;

class IncidentObserver
{
    /**
     * Håndterer oprettelsen af en Incident og opdaterer Carrier status.
     *
     * @param  \App\Models\Incident  $incident
     * @return void
     */
    public function created(Incident $incident)
    {
        foreach ($incident->carriers as $carrier) {
            $carrier->updateStatus();
        }

        foreach ($incident->services as $service) {
            $service->updateStatus();
        }
    }

    /**
     * Håndterer opdatering af en Incident og opdaterer Carrier status.
     *
     * @param  \App\Models\Incident  $incident
     * @return void
     */
    public function updated(Incident $incident)
    {
        foreach ($incident->carriers as $carrier) {
            $carrier->updateStatus();
        }

        foreach ($incident->services as $service) {
            $service->updateStatus();
        }
    }

    /**
     * Håndterer sletning af en Incident og opdaterer Carrier status.
     *
     * @param  \App\Models\Incident  $incident
     * @return void
     */
    public function deleted(Incident $incident)
    {
        foreach ($incident->carriers as $carrier) {
             $carrier->updateStatus();
        }

        foreach ($incident->services as $service) {
            $service->updateStatus();
        }
    }
}
