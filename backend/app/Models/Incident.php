<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Incident extends Model
{
    use HasFactory;

    protected $primaryKey = 'incident_id'; 

    protected $fillable = [
        'title',
        'message',
        'critical',
        'country',
        'status',
        'expected_resolved_at',
        'resolved_at'
    ];

    // Relation to Carrier (via incident_carriers)
    public function carriers()
    {
        return $this->belongsToMany(Carrier::class, 'incident_carriers', 'incident_id', 'carrier_id');
    }

    // Relationship to Service (via incident_services)
    public function services()
    {
        return $this->belongsToMany(Service::class, 'incident_services', 'incident_id', 'service_id');
    }

    
    // Automatically attaches carriers and services to the incident when a new incident is created.
    protected static function booted()
    {
        static::created(function (Incident $incident) {
            if (request()->has('carrier_ids')) {
                $incident->carriers()->attach(request('carrier_ids'));
            }

            if (request()->has('service_ids')) {
                $incident->services()->attach(request('service_ids'));
            }
        });
    }

    public function checkAndExpire()
    {
        $currentTime = Carbon::now('Europe/Copenhagen');

        // Check if the incident should be marked as expired and if resolved_at is reached
        if ($this->status === 'active') {
            if ($this->resolved_at && $currentTime->greaterThanOrEqualTo($this->resolved_at)) {
                $this->status = 'expired';
            }

            // If expected_resolved_at is reached and resolved_at is not already set
            if ($this->expected_resolved_at && $currentTime->greaterThanOrEqualTo($this->expected_resolved_at) && !$this->resolved_at) {
                $this->status = 'expired';
                $this->resolved_at = $currentTime;
            }

            $this->save();
        }
    }
}