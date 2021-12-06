<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class cronEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send welcome email with login credentials';

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
     * @return mixed
     */
    public function handle()
    {
        //
//        $schedule->command('queue:restart')
//            ->everyFiveMinutes();
//        $schedule->command('queue:work --daemon')
//            ->everyFiveMinutes();
        Log::info('I was here @ '.Carbon::Now());
    }
}
