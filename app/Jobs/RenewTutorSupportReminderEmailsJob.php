<?php

namespace App\Jobs;
use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class RenewTutorSupportReminderEmailsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $expired_courses;
    private $email_template;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($expired_courses,$email_template)
    {
        $this->expired_courses = $expired_courses;
        $this->email_template = $email_template;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach($this->expired_courses as $expired_course){
            $to_name  = $expired_course['first_name'].' '.$expired_course['last_name'];
            $subject = $this->email_template[0]->subject .' - '.$expired_course['course_id'];

            $args = array(
                'first_name' => $expired_course['first_name'],
                'last_name' => $expired_course['last_name'],
                'email' => $expired_course['email'],
                'password' => $expired_course['first_name'].'_'.$expired_course['last_name'],
            );

            $body = \App\Http\Controllers\UserController::email_shortcodes($this->email_template[0]->description,$args);
            $to_email = $expired_course['email'];//$request->email
            \Mail::send([], [], function($message) use ($to_name, $to_email,$subject,$body) {
                $message->to($to_email,$to_name)->subject($subject);
                $message->setBody($body, 'text/html');
                $message->from('no-reply@studentsupportsite.co.uk','iLearn it Easy');
            });

        }
    }
}
