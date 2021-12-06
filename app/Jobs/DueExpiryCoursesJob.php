<?php
namespace App\Jobs;
use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class DueExpiryCoursesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $stud_courses;
    private $email_template;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($stud_courses,$template)
    {
        $this->stud_courses = $stud_courses;
        $this->email_template = $template;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        foreach($this->stud_courses as $student_course){

            $to_name  = $student_course['first_name'].' '.$student_course['last_name'];
            $subject = $this->email_template[0]->subject .' - '.$student_course['course_id'];

            $args = array(
                'first_name' => $student_course['first_name'],
                'last_name' => $student_course['last_name'],
                'email' => $student_course['email'],
                'password' => $student_course['first_name'].'_'.$student_course['last_name'],
            );

            $body = \App\Http\Controllers\UserController::email_shortcodes($this->email_template[0]->description,$args);
            $to_email = $student_course['email'];//$request->email
            \Mail::send([], [], function($message) use ($to_name, $to_email,$subject,$body) {
                $message->to($to_email,$to_name)->subject($subject);
                $message->setBody($body, 'text/html');
                $message->from('no-reply@studentsupportsite.co.uk','iLearn it Easy');
            });

        }
    }
}
