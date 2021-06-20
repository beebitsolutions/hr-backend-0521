<?php

namespace App\Console\Commands;

use App\Http\Controllers\ParkController;
use Illuminate\Console\Command;

class ownersLeave extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'owners:leave';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will be run each hour and remove records from park_dogs table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $parkController = new ParkController();
        $parkController->forceOwnersLeave();
        return 0;
    }
}
