<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\ParkController;

class owners extends Command
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
    protected $description = 'Force owners to leave';

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
        $controller = new ParkController();
        $controller->forceOwnersLeave();
        $this->info('Owners forced to leave');
    }
}
