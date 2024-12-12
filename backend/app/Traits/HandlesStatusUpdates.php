<?php

namespace App\Traits;

trait HandlesStatusUpdates
{
    public function updateStatus()
    {
        $activeIncidents = $this->incidents->where('status', 'active');
        $criticalIncidents = $this->incidents->where('critical', true);

        if ($criticalIncidents->count() > 0) {
            $this->status = 'red';
        } elseif ($activeIncidents->count() > 0) {
            $this->status = 'yellow';
        } else {
            $this->status = 'green';
        }

        $this->save();
    }
}