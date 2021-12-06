<?php
namespace App\Jobs;
use App\User;
use App\Mail\GenericEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class EmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $user;
    private $sender_id;
    private $reciever_emails;
    private $subject;
    private $body;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user,$sender_id,$reciever_emails,$subject,$body)
    {
        $this->user = $user;
        $this->sender_id = $sender_id;
        $this->reciever_emails = $reciever_emails;
        $this->subject = $subject;
        $this->body = $body;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = array( 'sender_id' => $this->sender_id,
            'reciever_emails' => $this->reciever_emails,
            'body' => $this->body,
            );

        $recievers = $this->reciever_emails;
        foreach($recievers as $to) {
            Mail::send('emails.generic', ['data' => $data], function($message) use ($to) {
                $message->to($to)->subject($this->subject);
                $message->from($this->user->email,$this->user->name);
            });
        }

    }
}
