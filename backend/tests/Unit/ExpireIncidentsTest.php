<?php

namespace Tests\Unit;

use App\Models\Incident;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use Carbon\Carbon;

class ExpireIncidentsTest extends TestCase
{
    use RefreshDatabase;

    public function testIncidentsExpireWhenExpectedResolvedAtReached()
    {
        $currentTime = Carbon::now('Europe/Copenhagen');

        $incident = Incident::create([
            'title' => 'Test Incident',
            'message' => 'This incident should expire.',
            'critical' => true,
            'status' => 'active',
            'expected_resolved_at' => $currentTime->subMinutes(5),
            'resolved_at' => null,
        ]);

        $this->assertEquals('active', $incident->status);

        Artisan::call('expire:incidents');

        $incident->refresh();

        $this->assertEquals('expired', $incident->status);
        $this->assertNotNull($incident->resolved_at);

        $resolvedAt = Carbon::parse($incident->resolved_at)->timezone('Europe/Copenhagen');
        $this->assertTrue($resolvedAt->diffInSeconds($currentTime) <= 10);
    }
}