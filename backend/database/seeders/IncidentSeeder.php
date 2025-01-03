<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Incident;
use Carbon\Carbon;

class IncidentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Incident::insert([
            [
                'title' => 'System Maintenance',
                'message' => 'Scheduled maintenance for server updates.',
                'critical' => false,
                'country' => 'Danmark',
                'status' => 'active',
                'expected_resolved_at' => Carbon::now('Europe/Copenhagen')->addMinutes(5),
                'resolved_at' => null,
                'created_at' => Carbon::now(),
            ],
            [
                'title' => 'Network Outage',
                'message' => 'Unexpected outage affecting multiple regions.',
                'critical' => true,
                'country' => 'Canada',
                'status' => 'active',
                'expected_resolved_at' => Carbon::now('Europe/Copenhagen')->addMinutes(10),
                'resolved_at' => null,
                'created_at' => Carbon::now(),
            ],
            [
                'title' => 'Power Failure',
                'message' => 'Power outage impacting delivery systems.',
                'critical' => true,
                'country' => 'Germany',
                'status' => 'active',
                'expected_resolved_at' => Carbon::now('Europe/Copenhagen')->addHours(2),
                'resolved_at' => null,
                'created_at' => Carbon::now(),
            ],
        ]);
    }
}
