<?php
namespace App\Http\Controllers;
use App\Student;
use App\Admin;
use App\Assignment;
use App\User;
use App\Tutor;
use App\IV;
use App\Course;
use App\EmailTemplate;
use App\AssignedCourse;
use App\Consideration;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AutomaticEmailController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function checkAuth(Request $request){
        //setting the credentials array
        $credentials = [
          'email' => $request->input('email'),
          'password' => $request->input('password'),
        ];
        //if credentials are wrong
        if(!Auth::attempt($credentials)){
            return response('Username or password does not match',403);
        }
        return response(Auth::user(), 201);
    }

    //check if student account is suspended
    public static function checkIfStudentSuspended($student_id){
        $result = DB::table('students')->where('id','=',$student_id)
            ->select('is_suspended')
            ->where('is_suspended','=',1)->first();
        return $result;
    }

    public function showMyAccount(){
        $logged_user = Auth::user();
        //get desired user data
        switch ($logged_user->role_id) {
            case 1:
                $user = DB::table('students');
                break;
            case 2:
                $user = DB::table('admins');
                break;
            case 3:
                $user = DB::table('tutors');
                break;
            case 4:
                $user = DB::table('iv');
                break;
        }
        $user = $user->where('user_id','=',$logged_user->id)->first();
        return view('my-account/my-account',compact('user',$user));
    }

    //get user account data based on his role
    public function myAccount(Request $request){
        $logged_user = Auth::user();

        if($request->hasFile('photo')) {
            $image_type = array('jpeg','jpg','bmp','png','gif','svg');
            $file = $request->file('photo');
            //you also need to keep file extension as well
            $name = $file->getClientOriginalName();
            $ext = pathinfo(storage_path().'/'.$name, PATHINFO_EXTENSION);
            if(in_array($ext,$image_type)){
                //using array instead of object
                $image['filePath'] = $name;
                $file->move(public_path().'/images/', $name);
                $photo = 'images/'. $name;
                $update_photo = true;
            }else{
                return redirect()->back()->withInput()->with('error', 'Image file your trying to upload is invalid');
            }
        }else{
            $update_photo = false;
        }

            //get desired user type data
            switch ($logged_user->role_id) {
                case 1:
                    $user = Student::where('user_id','=',$logged_user->id);
                    ($update_photo) ? $user->update(array(
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'email' => $request->email,
                        'photo_id' => $photo,
                        'address' => $request->address,
                        'mobile_number' => $request->mobile,
                    )) : $user->update(array(
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'email' => $request->email,
                        'address' => $request->address,
                        'mobile_number' => $request->mobile,
                    ));
                    break;
                case 2:
                    $user = Admin::where('user_id','=',$logged_user->id);
                    ($update_photo) ? $user->update(array(
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'email' => $request->email,
                        'photo_id' => $photo,
                        'address' => $request->address,
                        'mobile_number' => $request->mobile,
                    )) : $user->update(array(
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'email' => $request->email,
                        'address' => $request->address,
                        'mobile_number' => $request->mobile,
                    ));
                    break;
                case 3:
                    $user = Tutor::where('user_id','=',$logged_user->id);
                    ($update_photo) ? $user->update(array(
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'email' => $request->email,
                        'photo_id' => $photo,
                        'address' => $request->address,
                        'mobile_number' => $request->mobile,
                        'signature_text' => $request->signature_text
                    )) : $user->update(array(
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'email' => $request->email,
                        'address' => $request->address,
                        'mobile_number' => $request->mobile,
                        'signature_text' => $request->signature_text
                    ));
                    break;
                case 4:
                    $user = IV::where('user_id','=',$logged_user->id);
                    ($update_photo) ? $user->update(array(
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'email' => $request->email,
                        'photo_id' => $photo,
                        'address' => $request->address,
                        'mobile_number' => $request->mobile,
                        'signature_text' => $request->signature_text
                    )) : $user->update(array(
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'email' => $request->email,
                        'address' => $request->address,
                        'mobile_number' => $request->mobile,
                        'signature_text' => $request->signature_text
                    ));
                    break;
            }
        if(!empty($user)){
            $msg = 'Profile Updated Successfully';
        }
        return redirect()->back()->withInput()->with('message', $msg);
    }

    //delete profile photo
    public function deleteProfilePhoto(Request $request)
    {
        $logged_user = Auth::user();
        //get desired user data
        switch ($logged_user->role_id) {
            case 1:
                $user = Student::where('user_id','=',$logged_user->id);
                $user->update(array(
                    'photo_id' => '',
                ));
                break;
            case 2:
                $user = Admin::where('user_id','=',$logged_user->id);
                $user->update(array(
                    'photo_id' => '',
                ));
                break;
            case 3:
                $user = Tutor::where('user_id','=',$logged_user->id);
                $user->update(array(
                    'photo_id' => '',
                ));
                break;
            case 4:
                $user = IV::where('user_id','=',$logged_user->id);
                $user->update(array(
                    'photo_id' => '',
                ));
                break;
        }
        //delete photo file physically from resource folder
        return redirect()->back()->withInput()->with('message', 'Profile Image Deleted');
    }

    //get user photo
    public static function getUserPhoto()
    {
        $user = Auth::user();//get user
        //get user photo after getting user role
        //student
        if($user->role_id == 1){
            $query = DB::table('students');
        }elseif($user->role_id == 2){
            $query = DB::table('admins');
        }elseif($user->role_id == 3){
            $query = DB::table('tutors');
        }elseif($user->role_id == 4){
            $query = DB::table('iv');
        }
        //get user role by id
        $photo_url =  $query->where('user_id','=',$user->id)->pluck('photo_id');
        return $photo_url[0];
    }

    //get User Id By Student Id
    public static function getUserIdByStudentId($student_id)
    {
        //get user id by student id
        $user_id = DB::table('students')->where('id','=',$student_id)->pluck('user_id');
        return $user_id[0];
    }

    //get User Id By Tutor Id
    public static function getUserIdByTutorId($tutor_id)
    {
        //get user id by student id
        $user_id = DB::table('tutors')->where('id','=',$tutor_id)->pluck('user_id');
        return $user_id[0];
    }

    //get User Id By IV Id
    public static function getUserIdByIVId($iv_id)
    {
        //get user id by student id
        $user_id = DB::table('iv')->where('id','=',$iv_id)->pluck('user_id');
        return $user_id[0];
    }

    //get user photo
    public static function getUserName($user_id)
    {
        $user = User::find($user_id);
        //student
        if($user->role_id == 1){
            $query = DB::table('students');
        }elseif($user->role_id == 2){
            $query = DB::table('admins');
        }elseif($user->role_id == 3){
            $query = DB::table('tutors');
        }elseif($user->role_id == 4){
            $query = DB::table('iv');
        }
        //get user role by id
        $full_name =  $query->select('first_name','last_name')->where('user_id','=',$user_id)->first();
        return $full_name;
    }

    //get user role by user id
    public static function getUserRole($user_id)
    {
        $user = User::find($user_id);
        if($user->role_id == 1){
            return 'student';
        }elseif($user->role_id == 2){
            return 'admin';
        }elseif($user->role_id == 3){
            return 'tutor';
        }elseif($user->role_id == 4){
            return 'iv';
        }
        return '';
    }

    //get student name by id
    public static function getStudentNameById($student_id)
    {
        $full_name = DB::table('students')
            ->select('first_name','last_name')
            ->where('id','=',$student_id)->first();
        return $full_name->first_name.' '.$full_name->last_name;
    }

    //create new student page
    public function showNewUsersPage(){
        $courses = DB::table('courses')->orderBy('name','asc')->get();
        $tutors = DB::table('tutors')->orderBy('first_name','asc')->get();
        $last_student_id = Student::max('id');
        $params = [
            'last_student_id'  => $last_student_id
        ];
        return view('students/create-users',compact('courses',$courses,'tutors',$tutors))->with($params);
    }

    private $pageLimit;
    //show students list - GET Method
    public function showStudents($page_var,Request $request){
        //get all courses by alphabetical order
        $courses = DB::table('courses')->select('id','name')->orderBy('name','asc')->get();
        $tutors = DB::table('tutors')->select('id','first_name','last_name')->orderBy('first_name','asc')->get();
        // Request::query('filter_by_course')
        // get dates from request OR create them, for students query
        // start_date
        if(!empty($request->input('start_date'))){
            $start_date = Carbon::createFromFormat('d/m/Y', $request->input('start_date'))->format('Y-m-d');
            //$end_date = Carbon::createFromFormat('d/m/Y', $request->input('end_date'))->format('Y-m-d');
//            $Q = Student::whereBetween('join_date',[$start_date,$end_date])->get();
//            return $Q;
            //$start_date = Student::select()->min('join_date');
        }else{//get the first date, as it will be smallest?
            $start_date = Student::select()->orderBy('join_date', 'asc')->pluck('join_date')->first();
        }

        //end date
        if(!empty($request->input('end_date'))){
            $end_date = Carbon::createFromFormat('d/m/Y', $request->input('end_date'))->format('Y-m-d');
            //$end_date = date("Y-m-d", strtotime($request->input('end_date')));
            //$end_date = Student::select()->where('join_date','=',$end_date)->orderBy('join_date', 'desc')->pluck('join_date')->first();
        }else{
            $end_date = Student::select()->orderBy('join_date', 'desc')->pluck('join_date')->first();
        }

        //initialize assigned courses query
        $student_by_course_query = DB::table('assigned_courses');
        if(!empty($request->filter_by_course)){
                $filter_course_id = $request->filter_by_course;
                //get (students ids) of students who has {course} assigned to them
                $student_by_course_query = $student_by_course_query->where('course_id','=',$filter_course_id);
                if($request->student_status == 'completed_courses' ){
                    $student_by_course_query = $student_by_course_query->where('is_completed','=',1);
                }
                $student_ids = $student_by_course_query->pluck('student_id');
                //init student_ids_string to make up student ids array for query
                $student_ids_string= [];
                foreach($student_ids as $id){
                    $student_ids_string[] = $id;
                }
        }

        if(empty($request->filter_by_course)){
            //check students who has completed courses
            if($request->student_status === 'completed_courses' ){
                $student_by_course_query = $student_by_course_query->where('is_completed','=',1);
                $student_ids = $student_by_course_query->pluck('student_id');
                //init student_ids_string to make up student ids array for query
                $student_ids_string= [];
                foreach($student_ids as $id){
                    $student_ids_string[] = $id;
                }
            }

            //check for expiring courses
            if($request->student_status == 'due_expiry' ){
                $now = Carbon::now()->addDays(30); // today date
                $student_by_course_query = $student_by_course_query->where('expiry_date','<',$now->toDateString());
                $student_ids = $student_by_course_query->pluck('student_id');
                //init student_ids_string to make up student ids array for query
                $student_ids_string= [];
                foreach($student_ids as $id){
                    $student_ids_string[] = $id;
                }
            }

            if($request->student_status == 'expired_courses' ){
                $now = Carbon::now()->format('Y-m-d'); // today date
                $student_by_course_query = $student_by_course_query->where('expiry_date','<=',$now);
                $student_ids = $student_by_course_query->pluck('student_id');

                //init student_ids_string to make up student ids array for query
                $student_ids_string= [];
                foreach($student_ids as $id){
                    $student_ids_string[] = $id;
                }
            }

            //check for students who requested course certificate
            if($request->student_status === 'requested_certificate' ){
                $student_by_course_query = $student_by_course_query->where('requested_certificate','=',1);
                $student_ids = $student_by_course_query->pluck('student_id');
                //init student_ids_string to make up student ids array for query
                $student_ids_string= [];
                foreach($student_ids as $id){
                    $student_ids_string[] = $id;
                }
            }
        }

        $logged_user = Auth::user();
        //if tutor logged in
        if ($logged_user->role_id === 3) {
            $tutor_courses = DB::table('tutors')->where('user_id','=',$logged_user->id)->pluck('assigned_courses');
            $tutor_courses = explode(',',$tutor_courses[0]);
            $tutor_courses = array_filter($tutor_courses);
            $query = DB::table('students');
            //build tutor's student query
            foreach($tutor_courses as $c){
                $query = $query->orWhere('assigned_student_courses','LIKE','%'.$c.',%');
            }
        }else{
            $query = DB::table('students');
        }

        // filter students from students table main query, so we can get only students for selected course
        if(!empty($request->filter_by_course) ){
               $query = $query->whereIn('id',$student_ids_string);
        }
        if(empty($request->filter_by_course)){
            if($request->student_status === 'completed_courses' ) {
                $query = $query->whereIn('id', $student_ids_string);
            }

        }

        //if student name / number is searched
        if(!empty($request->search_by_name_or_number)){
            $query = $query->where('first_name','LIKE',$request->search_by_name_or_number.'%');
            //$query = $query->orWhere('last_name','LIKE',$request->search_by_name_or_number.'%');
            //only if all colleges are selected by default
            if($request->filter_by_college === 'ALL'){
               $query = $query->orWhere('student_number', 'LIKE', $request->search_by_name_or_number . '%');
                //student status filter
                if($request->input('student_status') == 'active' ){
                    $query = $query->where('is_active','=',1);
                }
                //archived students status filter
                if($request->input('student_status') == 'archived_students' ){
                    $query = $query->where('is_active','=',0);
                }
                if($request->student_status == 'suspended_students' ){
                    $query = $query->where('is_suspended','=',1);
                }
            }else{
               $query = $query->where('student_number','LIKE',$request->filter_by_college.'%');
                //student status filter
                if($request->input('student_status') == 'active' ){
                    $query = $query->where('is_active','=',1);
                }
                //archived students status filter
                if($request->input('student_status') == 'archived_students' ){
                    $query = $query->where('is_active','=',0);
                }
                if($request->student_status == 'suspended_students' ){
                    $query = $query->where('is_suspended','=',1);
                }
            }
        }else{
            $query = $query->where('student_number','LIKE',$request->filter_by_college.'%');
            //student status filter
            if($request->input('student_status') == 'active' ){
                $query = $query->where('is_active','=',1);
            }
            //archived students status filter
            if($request->input('student_status') == 'archived_students' ){
                $query = $query->where('is_active','=',0);
            }
            if($request->student_status == 'suspended_students' ){
                $query = $query->where('is_suspended','=',1);
            }
        }

        //add dates filter now
        if($request->input('start_date') != '' AND $request->input('end_date') != ''){
            $query = $query->whereBetween('join_date', [$start_date,$end_date]);
            //$query = $query->where('join_date', '<=', '2021-03-19');
        }elseif(!empty($start_date AND $end_date) ){
            $query = $query->whereBetween('join_date', [$start_date,$end_date]);
        }

        //sort by surname filter
        if($request->sort_by === 'surname' ){
            $query = $query->orderBy('last_name','asc');
        }
        //sort by join_date filter
        if($request->sort_by === 'join_date' ){
            $query = $query->orderBy('join_date','desc');
        }

        //$query = $query->where('created_at','=',$end_date);
        $total = $query->count();

        //$this->pageLimit = 10;

        $this->pageLimit = 20;

        //get page limit from the form post variable
        if($this->pageLimit){
            // how many records to get
            $query = $query->take($this->pageLimit);

            //how many records to skip
            $query = $query->skip( ($page_var-1) * $this->pageLimit );

            //total pages
            $totalPages = ceil($total / $this->pageLimit);
        }

        // check if enter page_var value is okay for pagination
        if($page_var > $totalPages){
            $page_var = 1;
        }

        $query->orderBy('created_at', 'desc');
        $students = $query->get();





        $student_assigned_courses = array();
        //get students incomplete assigned courses
        foreach($students as $student){
            $student_assigned_courses[$student->id] = DB::table('assigned_courses')
                ->where('student_id','=',$student->id)
                ->where('is_completed','=',0)
                ->get();
        }

        $params = [
            'total'  => $total,
            'totalPages'   => $totalPages,
            'page_var'   => $page_var,
            'student_assigned_courses'   => $student_assigned_courses,
        ];


        //if tutor is logged in
        if ($logged_user->role_id === 3) {
            return view('students/tutor-assigned-students',compact('students' , $students,'courses' , $courses,'tutors' , $tutors))->with($params);
        }else{
            return view('students/list', compact('students', $students, 'courses', $courses, 'tutors', $tutors))->with($params);
        }
    }

    /*
     * @addStudents
     * CreateUser
     * CreateStudent
     *
     * create user record for two tables (users, students)
     * users table record is for general user that will be able to login into the system
     * and can access the system having a user_role_id
     *
     * students table record is to keep the user's student role information
     * */
    public function addStudents(Request $request)
    {
        if ($request->ajax()) {
            //create new user
            $bcrypt_pass = bcrypt($request->first_name.'_'.$request->last_name);
            //$unique_username = $request->first_name.'_'.$this->generateRandomString();
            $user = new User;
            $user->name = $request->first_name.' '.$request->last_name; //concatenated 'first_name last_name'
            $user->username = $request->email;
            $user->password = $bcrypt_pass;
            $user->email = $request->email;
            $user->role_id = 1;//for student only
            $user->is_verified = 0;
            $user->save();

            if(!empty($user->id)){
                //create new student
                $student = new Student;
                $student->user_id = $user->id;
                $student->student_number = $request->scode.$request->student_number;
                $student->is_active = 1;
                $student->is_suspended = 0;
                $student->first_name = $request->first_name;
                $student->last_name = $request->last_name;
                $student->email = $request->email;
                $student->phone_number = $request->phone_number;
                $student->mobile_number = $request->mobile_number;
                $student->address = $request->address;
                $string = '';
                for ($i = 1; $i <= 5; $i++) {
                    if($request->has("course_".$i)) {
                        //create assigned_student_courses string
                        $string = $string.$request->input("course_".$i).',';
                    }
                }
                $student->assigned_student_courses = $string;

                //login details
                //$student->username = $request->email;
                //$student->password = $bcrypt_pass;
                //find course & tutors ids
//                $student->fast_track = ($request->fast_track === 'on') ? 1 : 0;
//                $student->discounted_student = ($request->discounted_student === 'on' ) ? 1 : 0;
//                $student->reseller = ($request->reseller === 'on' ) ? 1 : 0;
//                $student->SEN = ($request->SEN === 'on' ) ? 1 : 0;
//                $student->SEN_notes = $request->sen_notes;
//                $student->payment_method = $request->payment;
                  $student->join_date = date("Y-m-d", strtotime($request->join_date));
//            if($request->hasFile('photo_id')) {
//                $file = $request->file('photo_id');
//                //you also need to keep file extension as well
//                $name = $file->getClientOriginalName();
//                //using array instead of object
//                $image['filePath'] = $name;
//                $file->move(public_path().'/images/', $name);
//                $student->photo_id = 'images/'. $name;
//                $image_uploaded = true;
//            }else{
//                $image_uploaded = false;
//            }
                $student->save();
            }

            //delete user if student wasnt able to be inserted
            if(empty($student->id)){
                DB::table("users")->where('id','=',$user->id)->delete();
                return false;
            }

            //if student was inserted -> assign selected course(s) to him
            if(!empty($student->id)){
                // add 365 days to the current time
                $current_date = Carbon::now();
                $courseExpires = $current_date->addDays(365);

                //go through possible courses and tutors
                for ($i = 1; $i <= 5; $i++) {
                    if($request->has("course_".$i)){
                        //create rows in assigned_courses table
                        $assign_course = new AssignedCourse;
                        $assign_course->student_id = $student->id;
                        $assign_course->course_id = $request->input("course_".$i);
                        $assign_course->tutor_id = $request->input("tutor_".$i);
                        $assign_course->course_discount = 0;
                        $assign_course->join_date = date("Y-m-d", strtotime($request->join_date));
                        $assign_course->expiry_date = $courseExpires;
                        $assign_course->is_completed = 0;
                        $assign_course->requested_certificate = 0;
                        if($request->fast_track === 'on'){
                            $assign_course->is_priority = 1;
                        }else{
                            $assign_course->is_priority = 0;
                        }
                        $assign_course->payment_method = $request->payment;
                        $assign_course->save();
                    }
                }
            }

            //student consideration - fast_track
            if($request->fast_track === 'on'){
                $consideration = new Consideration;
                $consideration->student_id = $student->id;
                $consideration->title = 'fast_track';
                $consideration->save();
                //($request->reseller === 'on' ) ? 1 : 0;
            }
            //student consideration - discounted
            if($request->discounted === 'on'){
                $consideration = new Consideration;
                $consideration->student_id = $student->id;
                $consideration->title = 'discounted';
                $consideration->save();
            }
            //student consideration - SEN
            if($request->sen === 'on'){
                $consideration = new Consideration;
                $consideration->student_id = $student->id;
                $consideration->title = 'sen';
                $consideration->notes = $request->sen_notes;
                $consideration->save();
            }

            //send welcome email to queue
            //WelcomeEmailJob::dispatch($user);

            //get email template from database
            $template = AutomaticEmailController::getEmailTemplate('User creation email');
            if($template){
                //get FROM email for user creation emails
                $to_name  = $request->first_name.' '.$request->last_name;
                $subject = $template[0]->subject;
                $args = array(
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'password' => $request->first_name.'_'.$request->last_name,
                );

                $body = $this->email_shortcodes($template[0]->description,$args);
                $to_email = $request->email;//$request->email
                \Mail::send([], [], function($message) use ($to_name, $to_email,$subject,$body) {
                    $message->to($to_email,$to_name)->subject($subject);
                    $message->setBody($body, 'text/html');
                    $message->from('no-reply@studentsupportsite.co.uk','Student Support Site');
                });
//                    \Mail::send('emails.generic', [], function ($message){
//                        $message->to('littlewebdeveloper@gmail.com')->subject('ARESP');
//                    });
            }

// Your PHP installation needs cUrl support, which not all PHP installations
// include by default.
// To run under docker:
// docker run -v $PWD:/code php:7.3.2-alpine php /code/code_sample.php

//                $username = '';
//                $password = '';
//                $messages = array(
//                    array('to' => $student->phone, 'body' => 'Welcome to ,'. $user->name),
//                   // array('to' => '+1233454568', 'body' => 'Hello World!')
//                );
//
//                $result = $this->send_message(json_encode($messages), 'https://api.bulksms.com/v1/messages?auto-unicode=true&longMessageMaxParts=30', $username, $password);
//                if ($result['http_status'] != 201) {
//                    print "Error sending: " . ($result['error'] ? $result['error'] : "HTTP status " . $result['http_status'] . "; Response was " . $result['server_response']);
//                } else {
//                    print "Response " . $result['server_response'];
//                    // Use json_decode($result['server_response']) to work with the response further
//                }
//            if($image_uploaded){
//                $resp[0] = array('image' => 'images/'. $name);
//                $resp[1] = array('success' => 'Student Added');
//                return response()->json($resp);
//            }
            //return redirect()->back()->withInput()->with('message', 'Student Created Successfully.');
            return response()->json($request->all());
        }else{
            return response()->json('Request Not Valid, Please try again later.');
        }
    }

    //replace shortcodes with related data
    static function email_shortcodes($content,array $args){
        //possible shortcodes
        $shortcode = array('first_name','last_name','email','password');
        foreach($shortcode as $scode){
            $content = preg_replace('/\{(first_name)\}.*?/', $args['first_name'], $content);
            $content = preg_replace('/\{(last_name)\}.*?/', $args['last_name'], $content);
            $content = preg_replace('/\{(email)\}.*?/', $args['email'], $content);
            $content = preg_replace('/\{(password)\}.*?/', $args['first_name'].'_'.$args['last_name'], $content);
            $content = preg_replace('/\{(password_reset_link)\}.*?/', route('password.request'), $content);
            if(isset($args['recommendation_1'])){
                $content = preg_replace('/\{(recommendation_1)\}.*?/', $args['recommendation_1'], $content);
            }
            if(isset($args['recommendation_2'])){
                $content = preg_replace('/\{(recommendation_2)\}.*?/', $args['recommendation_2'], $content);
            }
            if(isset($args['recommendation_3'])) {
                $content = preg_replace('/\{(recommendation_3)\}.*?/', $args['recommendation_3'], $content);
            }
        }
        return $content;
    }

    //archive selected students
    public function archiveStudent(Request $request)
    {
        $msg = '';
        if($request->method == 'archive'){
            $id = $request->archived_student_id;
            $student = Student::find($id);
            if(!empty($student)) {
                $student->is_active = 0;//mark student inactive
                $student->save();
            }
            $msg = 'Student Archived Successfully.';
        }

        if($request->method == 'suspend'){
            $id = $request->suspended_student_id;
            $student = Student::find($id);
            if(!empty($student)) {
                $student->is_suspended = 1;//suspend student account
                $student->save();
            }

            $user = User::find($student->user_id);
            if(!empty($user)) {
                $user->status = 0;//suspend user account
                $user->save();
            }
            $msg = 'Student Suspended Successfully.';
        }

        if($request->method == 'unsuspend'){
            $id = $request->unsuspended_student_id;
            $student = Student::find($id);
            if(!empty($student)) {
                $student->is_suspended = 0;//Unsuspend student account
                $student->save();
            }

            $user = User::find($student->user_id);
            if(!empty($user)) {
                $user->status = 1;//Reactivate user account
                $user->save();
            }
            $msg = 'Student Unsuspended Successfully.';
        }

        if($request->method == 'priority'){
            $id = $request->priority_student_id;
            $updateDetails = [
                'is_priority' => 1,
            ];

            //update course(s) for student where priority was 0
            DB::table('assigned_courses')
                ->where('student_id','=', $id)->where('is_priority','=',0)
                ->update($updateDetails);
            $msg = 'Student Set to Priority Successfully.';
        }

        $logged_user = Auth::user();
        //get desired user data
        switch ($logged_user->role_id) {
            case 1:
                $user_id = DB::table('students')->where('user_id','=',$logged_user->id)->pluck('id');
                break;
            case 2:
                $user_id = DB::table('admins')->where('user_id','=',$logged_user->id)->pluck('id');
                break;
            case 3:
                $user_id = DB::table('tutors')->where('user_id','=',$logged_user->id)->pluck('id');
                break;
            case 4:
                $user_id = DB::table('iv')->where('user_id','=',$logged_user->id)->pluck('id');
                break;
        }

        //course assignment upload by ADMIN instead of student himself
        if($request->method == 'assignment_upload_for_dashboard'){
                //get course type (standard, work_based)
                if($request->assignment_dashboard_course_type === 'standard'){

                    $assignment = new Assignment;
                    $assignment->assignment_file = $request->uploaded_file;
                    $assignment->assignment_number = $request->dashboard_assignment_number;
                    $assignment->course_id = $request->assignment_dashboard_course_id;
                    $assignment->student_id = $request->assignment_dashboard_student_id;
                    $assignment->status = 'awaiting_feedback';
                    $assignment->admin_id_if_admin_uploaded = $user_id[0];

                    if($request->hasFile('uploaded_file')) {
                        $image_type = array('jpeg','jpg','bmp','png','gif','svg','docx','doc');
                        $file = $request->file('uploaded_file');
                        //you also need to keep file extension as well
                        $name = $file->getClientOriginalName();
                        $ext = pathinfo(storage_path().'/'.$name, PATHINFO_EXTENSION);
                        if(in_array($ext,$image_type)){
                            $image['filePath'] = $name;
                            $file->move(public_path().'/assignments/', $name);
                            $assignment->assignment_file = '/assignments/'.$name;
                            $assignment->save();
                            $msg = 'Success';
                            return $msg;
                        }else{
                            return redirect()->back()->withInput()->with('error', 'Invalid file uploaded');
                        }
                    }
                }

            //for work based courses
            if($request->assignment_dashboard_course_type === 'work'){
                $assignment = new Assignment;
                $assignment->assignment_file = $request->uploaded_file;
                $assignment->assignment_number = $request->dashboard_assignment_number;
                $assignment->course_id = $request->assignment_dashboard_course_id;
                $assignment->student_id = $request->assignment_dashboard_student_id;
                $assignment->status = 'awaiting_feedback';
                $assignment->admin_id_if_admin_uploaded = $user_id[0];

                if($request->hasFile('uploaded_file')) {
                    $image_type = array('jpeg','jpg','bmp','png','gif','svg','docx','doc');
                    $file = $request->file('uploaded_file');
                    //you also need to keep file extension as well
                    $name = $file->getClientOriginalName();
                    $ext = pathinfo(storage_path().'/'.$name, PATHINFO_EXTENSION);
                    if(in_array($ext,$image_type)){
                        $image['filePath'] = $name;
                        $file->move(public_path().'/assignments/', $name);
                        $assignment->assignment_file = '/assignments/'.$name;
                        $assignment->save();
                        $msg = 'Success';
                        return $msg;
                    }else{
                        return redirect()->back()->withInput()->with('error', 'Invalid file uploaded');
                    }
                }
            }
        }

        //course assignment upload by ADMIN instead of student himself
        if($request->method == 'admin_marking_assignment_upload'){
//            //get course type (standard, work_based)
//                if($request->assignment_dashboard_course_type === 'standard'){
//
//                $assignment = new Assignment;
//                $assignment->assignment_file = $request->uploaded_file;
//                $assignment->assignment_number = $request->dashboard_assignment_number;
//                $assignment->course_id = $request->assignment_dashboard_course_id;
//                $assignment->student_id = $request->assignment_dashboard_student_id;
//                $assignment->status = 'awaiting_feedback';
//                $assignment->admin_id_if_admin_uploaded = $user_id[0];
//
//                if($request->hasFile('uploaded_file')) {
//                    $image_type = array('jpeg','jpg','bmp','png','gif','svg','docx','doc');
//                    $file = $request->file('uploaded_file');
//                    //you also need to keep file extension as well
//                    $name = $file->getClientOriginalName();
//                    $ext = pathinfo(storage_path().'/'.$name, PATHINFO_EXTENSION);
//                    if(in_array($ext,$image_type)){
//                        $image['filePath'] = $name;
//                        $file->move(public_path().'/assignments/', $name);
//                        $assignment->assignment_file = '/assignments/'.$name;
//                        $assignment->save();
//                        $msg = 'Success';
//                        return $msg;
//                    }else{
//                        return redirect()->back()->withInput()->with('error', 'Invalid file uploaded');
//                    }
//                }
//            }

            //get course type (standard, work_based)
            if($request->assignment_marking_course_type == 'work'){
                $assignment = new Assignment;
                $assignment->assignment_number = $request->marking_assignment_number;
                $assignment->course_id = $request->assignment_marking_course_id;
                $assignment->student_id = $request->assignment_marking_student_id;
                $assignment->unit_evidence_id = 0;//no evidence id as we have no evidence selected from form.
                $assignment->status = 'awaiting_feedback';
                $assignment->admin_id_if_admin_uploaded = $user_id[0];

                if($request->hasFile('marking_uploaded_file')) {
                    $image_type = array('jpeg','jpg','bmp','png','gif','svg','docx','doc');
                    $file = $request->file('marking_uploaded_file');
                    //you also need to keep file extension as well
                    $name = $file->getClientOriginalName();
                    $ext = pathinfo(storage_path().'/'.$name, PATHINFO_EXTENSION);
                    if(in_array($ext,$image_type)){
                        $image['filePath'] = $name;
                        $file->move(public_path().'/assignments/', $name);
                        $assignment->assignment_file = '/assignments/'.$name;
                        $assignment->save();
                        $msg = 'Success';
                        return $msg;
                    }else{
                        return redirect()->back()->withInput()->with('error', 'Invalid file uploaded');
                    }
                }
            }
        }

        //update student profile
        if($request->method === 'student_profile_edit'){
            $studentTableUpdates = [
                'student_number' => $request->student_number,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone_number' => $request->phone,
                'mobile_number' => $request->mobile,
                'address' => $request->address,
            ];

            //update course(s) for student where priority was 0
            DB::table('students')
                ->where('id','=', $request->student_id)
                ->update($studentTableUpdates);

            //considerations
            if($request->is_sen == 'on'){
                $consideration = Consideration::firstOrNew(array('title' => 'sen'));
                $consideration->title = 'sen';
                $consideration->student_id = $request->student_id;
                $consideration->save();
            }else{
                //delete the consideration if exists
                DB::table("student_consideration")
                    ->where('student_id','=',$request->student_id)
                    ->where('title','=','sen')
                    ->delete();
            }


            if($request->is_reseller == 'on'){
                $consideration = Consideration::firstOrNew(array('title' => ''));
                $consideration->title = 'reseller';
                $consideration->student_id = $request->student_id;
                $consideration->save();
            }else{
                DB::table("student_consideration")
                    ->where('student_id','=',$request->student_id)
                    ->where('title','=','reseller')
                    ->delete();
            }

            if($request->is_discounted == 'on'){
                $consideration = Consideration::firstOrNew(array('title' => $request->is_discounted));
                $consideration->title = 'discounted';
                $consideration->student_id = $request->student_id;
                $consideration->save();
            }else{
                DB::table("student_consideration")
                    ->where('student_id','=',$request->student_id)
                    ->where('title','=','discounted')
                    ->delete();
            }
            $msg = 'Success!';
        }

        return redirect()->back()->withInput()->with('message', $msg);
    }

    //delete selected students
    public function deleteStudent(Request $request)
    {
        $id = $request->id;
        DB::table("students")->where('id','=',$id)->delete();
        //return back()->withInput()->with('message', 'success');
        return redirect()->back()->withInput()->with('message', 'Student Deleted Successfully.');
    }

    function generateRandomString($length = 5) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}