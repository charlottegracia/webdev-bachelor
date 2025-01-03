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
     *
     * @return void
     */
    public function run()
    {
        $services = [
            [
                'title' => 'SHOP INTEGRATIONER',
                'status' => 'green',
                'description' => 'Shop integrationer',
                'created_at' => Carbon::now(),
            ],
            [
                'title' => 'SHIPMENT API',
                'status' => 'green',
                'description' => 'Shipment API',
                'created_at' => Carbon::now(),
            ],
            [
                'title' => 'SERVICEPOINT API',
                'status' => 'green',
                'description' => 'Servicepoint API',
                'created_at' => Carbon::now(),
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
