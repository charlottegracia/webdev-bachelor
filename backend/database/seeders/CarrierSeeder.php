<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Carrier;
use Carbon\Carbon;

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
                'description' => 'Express carrier for urgent deliveries.',
                'status' => 'green',
                'peak_up_charge' => 10.00,
                'created_at' => Carbon::now(),
            ],
            [
                'slug' => 'bring',
                'title' => 'Bring',
                'description' => 'An international carrier with fast delivery.',
                'status' => 'green',
                'peak_up_charge' => 20.00,
                'created_at' => Carbon::now(),
            ],
            [
                'slug' => 'psn',
                'title' => 'PostNord',
                'description' => 'A reliable local carrier.',
                'status' => 'green',
                'peak_up_charge' => 15.00,
                'created_at' => Carbon::now(),
            ],
        ]);
    }
}
