<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'title' => 'SHOP INTEGRATIONER',
                'status' => 'green',
                'description' => 'Shop integrationer',
            ],
            [
                'title' => 'SHIPMENT API',
                'status' => 'green',
                'description' => 'Shipment API',
            ],
            [
                'title' => 'SERVICEPOINT API',
                'status' => 'green',
                'description' => 'Servicepoint API',
            ],
        ];

        foreach ($services as $service) {
            // Check if the service already exists by its unique title
            if (!Service::where('title', $service['title'])->exists()) {
                Service::create($service);
            }
        }
    }
}
