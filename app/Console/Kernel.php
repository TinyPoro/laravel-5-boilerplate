<?php

namespace App\Console;

use App\Console\Commands\AbstractFactory;
use App\Console\Commands\Adapter;
use App\Console\Commands\CreatePermission;
use App\Console\Commands\CreateRole;
use App\Console\Commands\FactoryMethod;
use App\Console\Commands\FakeData;
use App\Console\Commands\Observer;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

/**
 * Class Kernel.
 */
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        CreateRole::class,
        FakeData::class,
        CreatePermission::class,
        AbstractFactory::class,
        FactoryMethod::class,
        Adapter::class,
        Observer::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
