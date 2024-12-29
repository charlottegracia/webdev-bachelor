<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HandlesStatusUpdates;

class Service extends Model
{
    use HasFactory;
    use HandlesStatusUpdates;

    protected $primaryKey = 'service_id'; 

    protected $fillable = [
        'title',
        'type',
        'status',
        'description'
    ];

    // Relation to Incident (via incident_services)
    public function incidents()
    {
        return $this->belongsToMany(Incident::class, 'incident_services', 'service_id', 'incident_id');
    }

    // Relation to Carrier (via carrier_services)
    public function carriers()
    {
        return $this->belongsToMany(Carrier::class, 'carrier_services', 'service_id', 'carrier_id');
    }

    // Polymorphic relation to FailureLogs (Service can have failure logs)
    public function failureLogs()
    {
        return $this->morphMany(FailureLog::class, 'loggable');
    }
}