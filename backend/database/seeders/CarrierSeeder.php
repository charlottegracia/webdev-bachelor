<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Carrier;

class CarrierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $carriers = [
            [
                'slug' => 'dao',
                'title' => 'DAO',
                'description' => 'Express carrier for urgent deliveries.',
                'status' => 'green',
                'peak_up_charge' => 10.00,
            ],
            [
                'slug' => 'bring',
                'title' => 'Bring',
                'description' => 'An international carrier with fast delivery.',
                'status' => 'green',
                'peak_up_charge' => 20.00,
            ],
            [
                'slug' => 'psn',
                'title' => 'PostNord',
                'description' => 'A reliable local carrier.',
                'status' => 'green',
                'peak_up_charge' => 15.00,
            ],
            [
                'slug' => 'gls',
                'title' => 'GLS',
                'description' => 'local carrier.',
                'status' => 'green',
                'peak_up_charge' => 15.00,
            ],
        ];

        foreach ($carriers as $carrier) {
            // Check if the carrier already exists by its unique slug
            if (!Carrier::where('slug', $carrier['slug'])->exists()) {
                Carrier::create($carrier);
            }
        }
    }
}