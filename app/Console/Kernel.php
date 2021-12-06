<?php
namespace App\Console;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
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
        'App\Console\Commands\DueExpiryCourses',
        'App\Console\Commands\TwoMonthsAutoEmails',
        'App\Console\Commands\RenewTutorSupportReminderEmails',
        'App\Console\Commands\RecommendationsForFurtherStudyEmails',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('command:DueExpiryCourses')
            ->daily();

        $schedule->command('command:TwoMonthsAutoEmails')
            ->daily();

        $schedule->command('command:RenewTutorSupportReminderEmails')
            ->daily();

        $schedule->command('command:RecommendationsForFurtherStudyEmails')
            ->daily();


//        $schedule->command('queue:restart')
//            ->everyFiveMinutes();
//
//        $schedule->command('queue:work --daemon --tries=3')
//            ->everyFiveMinutes()
//            ->withoutOverlapping();

//Log::info('I was here @ '.Carbon::Now());
//
//        $schedule->command('queue:work --daemon --tries=3')
//            ->everyMinute()
//            ->withoutOverlapping();

//        $schedule->command('queue:restart')
//            ->everyFiveMinutes();
//
//        $schedule->command('queue:work --daemon --tries=3')
//            ->everyMinute()
//            ->withoutOverlapping();

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
