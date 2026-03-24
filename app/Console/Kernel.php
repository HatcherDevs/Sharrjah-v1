<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
        Commands\DeployRefresh::class,
        Commands\ManageBlockedIps::class,
        Commands\BackupWebsite::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // backup يومي لقاعدة البيانات فقط — سريع وخفيف
        $schedule->command('backup:website --only-db')
            ->dailyAt('02:00')
            ->appendOutputTo(storage_path('logs/backup.log'));

        // backup أسبوعي كامل (public/ + قاعدة البيانات) — كل أحد
        $schedule->command('backup:website')
            ->weeklyOn(0, '03:00')
            ->appendOutputTo(storage_path('logs/backup.log'));
    }
}
