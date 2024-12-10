<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrier extends Model
{
    use HasFactory;

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
        return $this->belongsToMany(Incident::class, 'incident_carriers', 'carrier_id', 'incident_id')
            ->withTimestamps();
    }

    // Relation til Service (via carrier_services)
    public function services()
    {
        return $this->belongsToMany(Service::class, 'carrier_services', 'carrier_id', 'service_id')
            ->withTimestamps();
    }

    // Polymorf relation til FailureLogs (Carrier kan have logs)
    public function failureLogs()
    {
        return $this->morphMany(FailureLog::class, 'loggable');
    }

    public function updateStatus()
    {
        $activeIncidents = $this->incidents->where('status', 'active');
        $criticalIncidents = $this->incidents->where('critical', true);

        if ($criticalIncidents->count() > 0) {
            $this->status = 'red';
        }

        elseif ($activeIncidents->count() > 0) {
            $this->status = 'yellow';
        }

        else {
            $this->status = 'green';
        }

        $this->save();
    }
}