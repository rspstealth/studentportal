<?php

namespace App\Console\Commands;
use DB;
use Carbon\Carbon;
use App\Jobs\RecommendationsForFurtherStudyEmailsJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class RecommendationsForFurtherStudyEmails extends Command
{
    private $courses_array;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:RecommendationsForFurtherStudyEmails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sent after they have completed the course. It sends recommendations for other courses they may be interested in studying.';

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
        $template = \App\Http\Controllers\AutomaticEmailController::getEmailTemplate('Recommendations for further study');
        if($template){
            //Sent 30 days before the student’s course expires (if they have not completed)
            //get active students
            $query = DB::table('students')->where('is_active','=',1);
            $students = $query->get();

            //get assigned expired courses of active students
            foreach($students as $student){

                $completed_courses = DB::table('assigned_courses')->select()
                    ->where('is_completed','=',1)
                    ->where('student_id','=',$student->id)
                    ->where('date_completed','!=',NULL)//not empty
                    ->where('date_completed','=',date("Y-m-d"))//today date
                    ->pluck('course_id');
               //var_dump($completed_courses);

                if(count($completed_courses)>0){
                    $recommendations = DB::table('courses')
                        ->whereNotIn('id',$completed_courses)
                        ->inRandomOrder()->take(3)->pluck('name');
                    //var_dump($recommendations);
                }
                else{
                    $recommendations[0] = '';
                    $recommendations[1] = '';
                    $recommendations[2] = '';
                }

                if(count($completed_courses)>0) {
                    $this->courses_array[] = array(
                        'student_id' => $student->id,
                        'first_name' => $student->first_name,
                        'last_name' => $student->last_name,
                        'email' => $student->email,
                        'recommendation_1' => $recommendations[0],
                        'recommendation_2' => $recommendations[1],
                        'recommendation_3' => $recommendations[2],
                    );
                }
               // var_dump('course1:'.$recommendations[0]);
            }

            if($this->courses_array === NULL){
                $this->courses_array = array();
            }

//            var_dump($this->courses_array);
//            exit;

            //\Log::info('I was here @ '.$this->courses_array[0]['recommended_courses'][0]);
           // exit;
            RecommendationsForFurtherStudyEmailsJob::dispatch($this->courses_array,$template);
        }
    }
}
