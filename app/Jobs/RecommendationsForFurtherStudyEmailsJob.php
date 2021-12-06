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

class RecommendationsForFurtherStudyEmailsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $completed_courses;
    private $email_template;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($completed_courses,$email_template)
    {
        $this->completed_courses = $completed_courses;
        $this->email_template = $email_template;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach($this->completed_courses as $_course){
            $to_name  = $_course['first_name'].' '.$_course['last_name'];
            $subject = $this->email_template[0]->subject;

            $args = array(
                'first_name' => $_course['first_name'],
                'last_name' => $_course['last_name'],
                'email' => $_course['email'],
                'password' => $_course['first_name'].'_'.$_course['last_name'],
                'recommendation_1' => $_course['recommendation_1'],
                'recommendation_2' => $_course['recommendation_2'],
                'recommendation_3' => $_course['recommendation_3'],
            );

            $body = \App\Http\Controllers\UserController::email_shortcodes($this->email_template[0]->description,$args);
            $to_email = $_course['email'];//$request->email
            \Mail::send([], [], function($message) use ($to_name, $to_email,$subject,$body) {
                $message->to($to_email,$to_name)->subject($subject);
                $message->setBody($body, 'text/html');
                $message->from('no-reply@studentsupportsite.co.uk','iLearn it Easy');
            });
        }
    }
}
