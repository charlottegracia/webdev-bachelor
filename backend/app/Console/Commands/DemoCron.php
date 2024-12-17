<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DemoCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This is demo cron';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Demo cron command is running');
    }
}
