<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentCarrier extends Model
{
    use HasFactory;

    protected $table = 'incident_carriers';

    public $timestamps = false;

    // Relation to Incident
    public function incident()
    {
        return $this->belongsTo(Incident::class, 'incident_id', 'incident_id');
    }

    // Relation to Carrier
    public function carrier()
    {
        return $this->belongsTo(Carrier::class, 'carrier_id', 'carrier_id');
    }
}