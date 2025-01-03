<?php

namespace Database\Seeders;
use App\Models\Incident;
use App\Models\Carrier;
use App\Models\Service;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (Carrier::count() == 0 && Incident::count() == 0 && Service::count() == 0) {
            $this->call([
                IncidentSeeder::class,
                CarrierSeeder::class,
                ServiceSeeder::class,
                IncidentCarrierSeeder::class,
            ]);
        } else {
            echo "Database is not empty, seeders will not run.";
        
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        }
    }
}
