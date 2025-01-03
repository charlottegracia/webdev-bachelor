<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;
use Carbon\Carbon;

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
            Service::create($service);
        }
    }
}
