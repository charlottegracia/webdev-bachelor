<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Incident;
use Carbon\Carbon;

class ExpireIncidents extends Command
{
    //The signature and description of the console command.
    protected $signature = 'expire:incidents';
    protected $description = 'Update status for incidents based on expected_resolved_at';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('ExpireIncidents command is running');

        $incidents = Incident::where('status', 'active')
        ->whereNotNull('expected_resolved_at')
        ->where('expected_resolved_at', '<=', Carbon::now('Europe/Copenhagen'))
        ->get();

        foreach ($incidents as $incident) {
            $incident->checkAndExpire();
        }

        $this->info('Incidents updated.');
    }
}
