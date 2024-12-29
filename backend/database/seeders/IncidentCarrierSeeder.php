<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Carrier;
use App\Models\Incident;

class IncidentCarrierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Retrieve all incidents and carriers
        $incidents = Incident::all();
        $carriers = Carrier::all();

        // Ensure we have enough incidents and carriers
        if ($incidents->count() < 3 || $carriers->count() < 3) {
            echo "Not enough incidents or carriers to proceed with the insert.";
            return;
        }

        // Insert random relations between incidents and carriers
        foreach ($incidents as $incident) {
            $incident->carriers()->attach($carriers->random()->carrier_id);
        }

         // Manually trigger the observer logic
         foreach ($incidents as $incident) {
            foreach ($incident->carriers as $carrier) {
                $carrier->updateStatus();
            }
        }
    }
}
