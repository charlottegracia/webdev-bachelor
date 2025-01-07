<?php

namespace Tests\Unit;

use App\Models\Carrier;
use App\Models\Incident;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CarrierStatusTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test carrier status update when an incident is created.
     *
     * @return void
     */
    public function testCarrierStatusUpdatesWhenIncidentCreated()
    {
        $carrier = Carrier::create([
            'slug' => 'test',
            'title' => 'Test',
            'description' => 'Test Carrier'  
        ]);

        $response = $this->postJson('/api/incidents', [
            'title' => 'Test Incident',
            'message' => 'This is a test incident.',
            'critical' => true,
            'status' => 'active',
            'carrier_ids' => [$carrier->carrier_id],
        ]);

        $response->assertStatus(201);

        $carrier->refresh();

        $this->assertEquals('red', $carrier->status);
    }
}