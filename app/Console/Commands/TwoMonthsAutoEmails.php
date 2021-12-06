<?php

namespace App\Console\Commands;

use DB;
use App\Jobs\TwoMonthsAutoEmailsJob;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TwoMonthsAutoEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:TwoMonthsAutoEmails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Emails to registered student two months after their join_date';

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
        $template = \App\Http\Controllers\AutomaticEmailController::getEmailTemplate('2 months automatic email');
        if($template){
            //get active students
            $current_date = Carbon::now();
            $before_two_months_from_now_date = $current_date->subMonths(2);
            $before_two_months_from_now_date = date("Y-m-d", strtotime($before_two_months_from_now_date));
            $query = DB::table('students')->select()->where('is_active','=',1);
            $query = $query->where('join_date','<',$before_two_months_from_now_date);
            $students = $query->get();
            echo 'stus';
            var_dump($students);
            exit;
            TwoMonthsAutoEmailsJob::dispatch($students,$template);
//
//            foreach($students as $student){
//                $to_name  = $student->first_name.' '.$student->last_name;
//                $subject = $template[0]->subject;
//                $args = array(
//                    'first_name' => $student->first_name,
//                    'last_name' => $student->last_name,
//                    'email' => $student->email,
//                    'password' => $student->first_name.'_'.$student->last_name,
//                );
//
//                $body = \App\Http\Controllers\UserController::email_shortcodes($template[0]->description,$args);
//                $to_email = $student->email;//$request->email
//                \Mail::send([], [], function($message) use ($to_name, $to_email,$subject,$body) {
//                    $message->to($to_email,$to_name)->subject($subject);
//                    $message->setBody($body, 'text/html');
//                    $message->from('no-reply@studentsupportsite.co.uk','Student Support Site sent using CRON');
//                });
//            }

        }
    }
}
