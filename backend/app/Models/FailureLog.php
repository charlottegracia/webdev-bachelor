<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FailureLog extends Model
{
    use HasFactory;

    protected $primaryKey = 'failure_log_id'; 

    protected $fillable = [
        'loggable_id',
        'loggable_type',
        'uuid',
        'connection',
        'reason',
        'failed_at'
    ];

    // Polymorphic relationship (can belong to Service or Carrier)
    public function loggable()
    {
        return $this->morphTo();
    }
}