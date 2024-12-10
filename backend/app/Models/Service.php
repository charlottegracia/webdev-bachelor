<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $primaryKey = 'service_id'; 

    protected $fillable = [
        'title',
        'type',
        'status',
        'description'
    ];

    // Relation til Incident (via incident_services)
    public function incidents()
    {
        return $this->belongsToMany(Incident::class, 'incident_services', 'service_id', 'incident_id')
            ->withTimestamps();
    }

    // Relation til Carrier (via carrier_services)
    public function carriers()
    {
        return $this->belongsToMany(Carrier::class, 'carrier_services', 'service_id', 'carrier_id')
            ->withTimestamps();
    }

    // Polymorf relation til FailureLogs (Service kan have failure logs)
    public function failureLogs()
    {
        return $this->morphMany(FailureLog::class, 'loggable');
    }
}