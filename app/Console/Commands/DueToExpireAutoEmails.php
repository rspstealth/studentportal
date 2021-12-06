<?php
namespace App\Console\Commands;

use DB;
use App\Jobs\DueToExpireAutoEmailsJob;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class DueToExpireAutoEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:DueToExpireAutoEmails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sent 30 days before the student’s course(s) expires (if they have not completed)';

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
        $template = \App\Http\Controllers\AutomaticEmailController::getEmailTemplate('Due to expire automatic email');
        if($template){
            //Sent 30 days before the student’s course expires (if they have not completed)
            //get active students
            $query = DB::table('students')->where('is_active','=',1);
            $students = $query->get();

            $students_with_due_expiry_courses = array();
            //get assigned incomplete courses of students
            foreach($students as $student){
                $time = strtotime($student->join_date);
                $final_date = date("Y-m-d", strtotime("+1 month", $time));
                $due_expiry_courses = DB::table('assigned_courses')->select()
                    ->where('is_completed','=',0)
                    ->where('student_id','=',$student->id)
                    ->where('expiry_date','<=',$final_date)
                    ->get();
                //echo '++++++++++++++++++++++++';
                //var_dump($due_expiry_courses);
                foreach($due_expiry_courses as $course){
                    $students_with_due_expiry_courses[] = array(
                        'student_id' => $student->id,
                        'first_name'  => $student->first_name,
                        'last_name'  => $student->last_name,
                        'email'  => $student->email,
                        'course_id'  => $course->course_id,
                    );
                }
            }
            DueToExpireAutoEmailsJob::dispatch($students_with_due_expiry_courses,$template)->onQueue('course_due_expiry_emails');
        }
    }
}
