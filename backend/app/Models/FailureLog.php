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

    // Polymorf relation (kan tilhøre Service eller Carrier)
    public function loggable()
    {
        return $this->morphTo();
    }
}