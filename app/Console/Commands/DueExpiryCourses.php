<?php

namespace App\Console\Commands;
use DB;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Jobs\DueExpiryCoursesJob;
use Illuminate\Support\Facades\Mail;

class DueExpiryCourses extends Command
{
    private $courses_array;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:DueExpiryCourses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $template = \App\Http\Controllers\AutomaticEmailController::getEmailTemplate('Due to expire automatic email');
        if($template){
            //Sent 30 days before the student’s course expires (if they have not completed)
            //get active students
            $query = DB::table('students')->where('is_active','=',1);
            $students = $query->get();

            $student_courses = array();
            //get assigned incomplete courses of students
            foreach($students as $student){
                $time = strtotime($student->join_date);
                $final_date = date("Y-m-d", strtotime("+1 month", $time));
                $due_expiry_courses = DB::table('assigned_courses')->select()
                    ->where('is_completed','=',0)
                    ->where('student_id','=',$student->id)
                    ->where('expiry_date','<=',$final_date)
                    ->get();

                foreach($due_expiry_courses as $course){
                    $this->courses_array[] = array(
                        'student_id' => $student->id,
                        'first_name'  => $student->first_name,
                        'last_name'  => $student->last_name,
                        'email'  => $student->email,
                        'course_id'  => $course->course_id,
                    );
                }
            }

            DueExpiryCoursesJob::dispatch($this->courses_array,$template);
        }
    }
}
