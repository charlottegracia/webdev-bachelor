<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentService extends Model
{
    use HasFactory;

    protected $table = 'incident_services';

    public $timestamps = false;

    // Relation to Incident
    public function incident()
    {
        return $this->belongsTo(Incident::class, 'incident_id', 'incident_id');
    }

    // Relation to Service
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'service_id');
    }
}