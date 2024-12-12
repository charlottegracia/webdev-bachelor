<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    use HasFactory;

    protected $primaryKey = 'incident_id'; 

    protected $fillable = [
        'title',
        'message',
        'critical',
        'country',
        'type',
        'status',
        'expected_resolved_at',
        'resolved_at'
    ];

    // Relation til Carrier (via incident_carriers)
    public function carriers()
    {
        return $this->belongsToMany(Carrier::class, 'incident_carriers', 'incident_id', 'carrier_id');
    }

    // Relation til Service (via incident_services)
    public function services()
    {
        return $this->belongsToMany(Service::class, 'incident_services', 'incident_id', 'service_id');
    }

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
}