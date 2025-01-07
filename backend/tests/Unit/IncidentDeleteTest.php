<?php

namespace Tests\Unit;

use App\Models\Carrier;
use App\Models\Service;
use App\Models\Incident;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IncidentDeleteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test carrier and service status reset when an incident is deleted.
     *
     * @return void
     */
    public function testStatusResetsWhenIncidentDeleted()
    {
        $carrier = Carrier::create([
            'slug' => 'test',
            'title' => 'Test',
            'description' => 'Test Carrier',
        ]);

        $service = Service::create([
            'title' => 'test',
            'description' => 'Test Service',
        ]);

        $incident = Incident::create([
            'title' => 'Test Incident',
            'message' => 'This is a test incident.',
            'critical' => true, 
            'status' => 'active',
        ]);

        $incident->carriers()->attach($carrier);
        $incident->services()->attach($service);

        $carrier->updateStatus();
        $service->updateStatus();

        $this->assertEquals('red', $carrier->status);
        $this->assertEquals('red', $service->status);

        $response = $this->deleteJson(route('api.incidents.delete', ['id' => $incident->incident_id]));
        $response->assertStatus(200);

        $carrier->refresh();
        $service->refresh();

        $this->assertEquals('green', $carrier->status);
        $this->assertEquals('green', $service->status);
    }
}