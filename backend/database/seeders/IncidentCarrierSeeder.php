<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Carrier;
use App\Models\Incident;
use App\Models\Service;

class IncidentCarrierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Retrieve all incidents, carriers and services
        $incidents = Incident::all();
        $carriers = Carrier::all();
        $services = Service::all();

        // Ensure we have enough incidents and carriers
        if ($incidents->count() < 3 || $carriers->count() < 3) {
            echo "Not enough incidents or carriers to proceed with the insert.";
            return;
        }

        // Insert random relations between incidents/carriers and incident/services
        foreach ($incidents as $incident) {
            $incident->carriers()->attach($carriers->random()->carrier_id);

            $incident->services()->attach($services->random()->service_id);
        }

        // Manually trigger the observer logic for carriers and services
        foreach ($incidents as $incident) {
           foreach ($incident->carriers as $carrier) {
               $carrier->updateStatus();
            }

            foreach ($incident->services as $service) {
                $service->updateStatus(); 
            }
        }
    }
}
