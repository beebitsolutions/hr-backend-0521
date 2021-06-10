<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\ParkController;
use Illuminate\Contracts\Container\BindingResolutionException;

class OwnersLeave extends Command
{
    /**
     * @var string
     */
    protected $signature = 'owners:leave';

    /**
     * @var string
     */
    protected $description = 'Force dog owners to leave the park within 1 hour.';

    /**
     * @throws BindingResolutionException
     */
    public function handle(): void
    {
        $parkController = app()->make(ParkController::class);
        app()->call([$parkController, 'forceOwnersLeave']);
    }
}
