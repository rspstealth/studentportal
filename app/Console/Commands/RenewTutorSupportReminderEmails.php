<?php

namespace App\Console\Commands;
use DB;
use Carbon\Carbon;
use App\Jobs\RenewTutorSupportReminderEmailsJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;


class RenewTutorSupportReminderEmails extends Command
{
    private $courses_array;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:RenewTutorSupportReminderEmails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sent after the course has expired (if they have not completed)';

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
        $template = \App\Http\Controllers\AutomaticEmailController::getEmailTemplate('Renew tutor support reminder');
        if($template){
            //Sent 30 days before the student’s course expires (if they have not completed)
            //get active students
            $query = DB::table('students')->where('is_active','=',1);
            $students = $query->get();

            //get assigned expired courses of active students
            foreach($students as $student){
                $expired_courses = DB::table('assigned_courses')->select()
                    ->where('is_completed','=',0)
                    ->where('expiry_date','<',$student->join_date)
                    ->get();

                foreach($expired_courses as $course){
                    $this->courses_array[] = array(
                        'student_id' => $student->id,
                        'first_name'  => $student->first_name,
                        'last_name'  => $student->last_name,
                        'email'  => $student->email,
                        'course_id'  => $course->course_id,
                    );
                }
            }

            RenewTutorSupportReminderEmailsJob::dispatch($this->courses_array,$template);
        }
    }
}
