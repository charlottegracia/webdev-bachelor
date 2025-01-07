<?php

namespace App\Observers;

use App\Models\Incident;

class IncidentObserver
{
    /**
     * Handles the creation of an Incident and updates Carrier and Service status.
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
     * Handles updating an Incident and updates the Carrier and Service status.
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
     * Handles the deletion of an Incident and updates the Carrier and Service status.
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

    /**
     * Handles the saving of an Incident and updates the Carrier and Service status.
     *
     * @param  \App\Models\Incident  $incident
     * @return void
     */
    public function saved(Incident $incident)
    {
        foreach ($incident->carriers as $carrier) {
             $carrier->updateStatus();
        }

        foreach ($incident->services as $service) {
            $service->updateStatus();
        }
    }
}
