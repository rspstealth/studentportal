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

class TwoMonthsAutoEmailsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $students;
    private $template;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($students,$template)
    {
        //
        $this->students = $students;
        $this->template = $template;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach($this->students as $student){
//            \Mail::send('emails.generic', [], function ($message){
//            $message->to('littlewebdeveloper@gmail.com')->subject('ARESP');
//        });
//            exit;

            $to_name  = $student->first_name.' '.$student->last_name;
            $subject = $this->template[0]->subject;
            $args = array(
                'first_name' => $student->first_name,
                'last_name' => $student->last_name,
                'email' => $student->email,
                'password' => $student->first_name.'_'.$student->last_name,
            );

            $body = \App\Http\Controllers\UserController::email_shortcodes($this->template[0]->description,$args);
            $to_email = $student->email;//$request->email
            \Mail::send([], [], function($message) use ($to_name, $to_email,$subject,$body) {
                $message->to($to_email,$to_name)->subject($subject);
                $message->setBody($body, 'text/html');
                $message->from('no-reply@studentsupportsite.co.uk','iLearn it Easy');
            });
        }
    }
}
