<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HandlesStatusUpdates;

class Carrier extends Model
{
    use HasFactory;
    use HandlesStatusUpdates;

    protected $primaryKey = 'carrier_id'; 

    protected $fillable = [
        'slug',
        'title',
        'type',
        'description',
        'status',
        'peak_up_charge'
    ];

    // Relation til Incident (via incident_carriers)
    public function incidents()
    {
        return $this->belongsToMany(Incident::class, 'incident_carriers', 'carrier_id', 'incident_id');
    }

    // Relation til Service (via carrier_services)
    public function services()
    {
        return $this->belongsToMany(Service::class, 'carrier_services', 'carrier_id', 'service_id');
    }

    // Polymorf relation til FailureLogs (Carrier kan have logs)
    public function failureLogs()
    {
        return $this->morphMany(FailureLog::class, 'loggable');
    }
}