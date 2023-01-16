<?php

namespace App\Console;

use App\Console\Commands\PublishTemplate;
use App\Console\Commands\RebuildPublic;
use App\Console\Commands\SoftLinkAsset;
use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        PublishTemplate::class,
        RebuildPublic::class,
        SoftLinkAsset::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //
    }
}
