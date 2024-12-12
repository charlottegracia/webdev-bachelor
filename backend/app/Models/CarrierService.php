<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarrierService extends Model
{
    use HasFactory;

    protected $table = 'carrier_services'; 

    public $timestamps = false;

    // Relation til Carrier
    public function carrier()
    {
        return $this->belongsTo(Carrier::class, 'carrier_id', 'carrier_id');
    }

    // Relation til Service
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'service_id');
    }
}