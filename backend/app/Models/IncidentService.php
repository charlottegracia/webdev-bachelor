<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentService extends Model
{
    use HasFactory;

    protected $table = 'incident_services';

    // Relation til Incident
    public function incident()
    {
        return $this->belongsTo(Incident::class, 'incident_id', 'incident_id');
    }

    // Relation til Service
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'service_id');
    }
}