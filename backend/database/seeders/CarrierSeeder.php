<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Carrier;

class CarrierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Carrier::insert([
            [
                'slug' => 'dao',
                'title' => 'DAO',
                'type' => 'express',
                'description' => 'Express carrier for urgent deliveries.',
                'status' => 'green',
                'peak_up_charge' => 10.00,
            ],
            [
                'slug' => 'bring',
                'title' => 'Bring',
                'type' => 'international',
                'description' => 'An international carrier with fast delivery.',
                'status' => 'green',
                'peak_up_charge' => 20.00,
            ],
            [
                'slug' => 'psn',
                'title' => 'PostNord',
                'type' => 'delivery',
                'description' => 'A reliable local carrier.',
                'status' => 'green',
                'peak_up_charge' => 15.00,
            ],
        ]);
    }
}
