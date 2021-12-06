<?php
namespace App\Http\Controllers;
use App\Tutor;
use App\User;
use App\IV;
use App\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\UserController;


class TutorController extends Controller
{
    // find best matched tutors by user query except given ids
    public function getTutorsAJAX(Request $request)
    {
        $tutor_list = DB::table('tutors')->select('id','first_name','last_name')->where('first_name','LIKE',"$request->tutor%");
        $tutor_list = $tutor_list->get();
        if ($request->ajax()) {
            return response()->json($tutor_list);
        }else{
            return response()->json($request->all());
        }
    }
    
    // get single tutor based on id
    public function getUserByIdAJAX(Request $request)
    {
        if ($request->ajax()) {
            if($request->method === 'students'){
                $user = DB::table('students')->where('id','=',$request->edit_student_id)->get();
                $student_considerations = DB::table('student_consideration')->where('student_id','=',$request->edit_student_id)->get();
                $student_login = DB::table('users')
                    ->where('id','=',$user[0]->user_id)
                    ->get();
                $user[] = $student_considerations;
                //$user[] = array('username'=> $student_login[0]->username);
                $course_ids_array = DB::table('assigned_courses')
                    ->where('student_id','=',$request->edit_student_id)
                    ->where('is_completed','=',0)
                    ->pluck('course_id');
                $course_ids_string= [];
                foreach($course_ids_array as $id){
                    $course_ids_string[] = $id;
                }
                $user[] = DB::table('courses')
                        ->join('assigned_courses','courses.id', '=', 'assigned_courses.course_id')
                        ->where('assigned_courses.student_id',$request->edit_student_id)
                        ->whereIn('courses.id',$course_ids_string)
                        ->get();
            }

            if($request->method === 'tutors'){
                $user = DB::table('tutors')->where('id','=',$request->edit_tutor_id)->get();
            }
            if($request->method === 'admins'){
                $user = DB::table('admins')->where('id','=',$request->edit_admin_id)->get();
            }
            if($request->method === 'ivs'){
                $user = DB::table('iv')->where('id','=',$request->edit_iv_id)->get();
            }
            return response()->json($user);
        }else{
            return response()->json('Request Not Valid, Please try again later.');
        }
    }


    private $pageLimit;
    // get all holidays
    public function showTutors($page_var,Request $request){
        $logged_in_user = Auth::user();
        //get all courses by alphabetical order
        $courses = DB::table('courses')->select('id','name')->orderBy('name','asc')->get();

        //get user based on request
        if($request->input('t')){ // if t parameter is set
            if($request->input('t') === 'tutors'){
                $query = DB::table('tutors')->select();
            }
            if($request->input('t') === 'admins'){
                $query = DB::table('admins')->select()->where('user_id','<>',$logged_in_user->id);
            }
            if($request->input('t') === 'ivs'){
                $query = DB::table('iv')->select();
            }
        }

        $total = $query->count();

        $this->pageLimit = 10;
        //get page limit from the form post variable
        if($this->pageLimit === 10){
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

        $users = $query->get();


        $params = [
            'total'  => $total,
            'totalPages'   => $totalPages,
            'page_var'   => $page_var,
        ];
        return view('tutors/list',compact('users', $users,'courses', $courses))->with($params);
    }

    public function addTutor(Request $request){
        if ($request->ajax()) {
                // add new tutor
                if($request->method === 'tutors'){
                    //create new user for admin
                    $user = new User;
                    $user->name = $request->first_name.' '.$request->last_name; //concatenated 'first_name last_name'
                    $user->username = $request->tutor_email;
                    $user->password = bcrypt($request->first_name.'_'.$request->last_name);
                    $user->email = $request->tutor_email;
                    $user->role_id = 3;//for tutors only
                    $user->is_verified = 0;
                    $user->save();

                    $tutor = new Tutor;
                    $tutor->user_id = $user->id;
                    $tutor->first_name = $request->first_name;
                    $tutor->last_name = $request->last_name;
                    $tutor->email = $request->tutor_email;
                    $tutor->address = $request->tutor_address;
                    $tutor->employment_status = $request->employment_status;
                    if($request->hasFile('signature')) {
                        $file = $request->file('signature');
                        //you also need to keep file extension as well
                        $name = $file->getClientOriginalName();
                        //using array instead of object
                        $image['filePath'] = $name;
                        $file->move(public_path().'/images/', $name);
                        $tutor->signature = 'images/'. $name;
                    }
                    $tutor->assigned_courses = $request->chosen_courses_ids;
                    $tutor->save();

                    //get email template by title
                    $template = AutomaticEmailController::getEmailTemplate('New User Creation Email');
                    if($template){
                        //get FROM email for user creation emails
                        $to_name  = $request->first_name.' '.$request->last_name;
                        $subject = $template[0]->subject;
                        $args = array(
                            'first_name' => $request->first_name,
                            'last_name' => $request->last_name,
                            'email' => $request->tutor_email,
                            'password' => $request->first_name.'_'.$request->last_name,
                        );
                        //call user model function
                        $body = UserController::email_shortcodes($template[0]->description,$args);
                        $to_email = $request->tutor_email;//$request->email
                        \Mail::send([], [], function($message) use ($to_name, $to_email,$subject,$body) {
                            $message->to($to_email,$to_name)->subject($subject);
                            $message->setBody($body, 'text/html');
                            $message->from('no-reply@studentsupportsite.co.uk','Student Support Site');
                        });
                    }
                    $msg = 'Tutor Added Successfully';
                }

                //updating tutor
                if($request->method === 'tutors_edit') {
                    $tutor = Tutor::find($request->edit_tutor_id);
                    $tutor->first_name = $request->edit_first_name;
                    $tutor->last_name = $request->edit_last_name;
                    $tutor->email = $request->edit_tutor_email;
                    $tutor->address = $request->edit_tutor_address;
                    $tutor->employment_status = $request->edit_employment_status;
                    if($request->hasFile('edit_signature')) {
                        $file = $request->file('edit_signature');
                        //you also need to keep file extension as well
                        $name = $file->getClientOriginalName();
                        //using array instead of object
                        $image['filePath'] = $name;
                        $file->move(public_path().'/images/', $name);
                        $tutor->signature = 'images/'. $name;
                    }
                    $tutor->assigned_courses = $request->edit_chosen_courses_ids;

                    if($tutor->save()){
                        //get email template by title
                        $template = AutomaticEmailController::getEmailTemplate('Settings for Tutor creation email');
                        if($template){
                            //get FROM email for user creation emails
                            $to_name  = $request->edit_first_name.' '.$request->edit_last_name;
                            $subject = $template[0]->subject;
                            $args = array(
                                'first_name' => $request->edit_first_name,
                                'last_name' => $request->edit_last_name,
                                'email' => $request->edit_tutor_email,
                                'password' => $request->edit_first_name.'_'.$request->edit_last_name,
                            );
                            //call user model function
                            $body = UserController::email_shortcodes($template[0]->description,$args);
                            $to_email = $request->edit_tutor_email;//$request->email
                            \Mail::send([], [], function($message) use ($to_name, $to_email,$subject,$body) {
                                $message->to($to_email,$to_name)->subject($subject);
                                $message->setBody($body, 'text/html');
                                $message->from('no-reply@studentsupportsite.co.uk','Student Support Site');
                            });
                        }
                        $msg = 'Tutor Updated Successfully';
                    }else{
                        $msg = 'Couldn\'t Update, Email Already Exists.';
                    }
                }

                if($request->method === 'admins'){
                    $query = DB::table('admins')->select();
                    //create new user for admin
                    $user = new User;
                    $user->name = $request->admin_first_name.' '.$request->admin_last_name; //concatenated 'first_name last_name'
                    $user->username = $request->admin_email;
                    $user->password = bcrypt($request->admin_first_name.'_'.$request->admin_last_name);
                    $user->email = $request->admin_email;
                    $user->role_id = 2;//for admins only
                    $user->is_verified = 0;
                    $user->save();

                    $admin = new Admin;
                    $admin->user_id = $user->id;
                    $admin->first_name = $request->admin_first_name;
                    $admin->last_name = $request->admin_last_name;
                    $admin->email = $request->admin_email;
                    $admin->save();

                    //get email template by title
                    $template = AutomaticEmailController::getEmailTemplate('New User Creation Email');
                    if($template){
                        //get FROM email for user creation emails
                        $to_name  = $request->admin_first_name.' '.$request->admin_last_name;
                        $subject = $template[0]->subject;
                        $args = array(
                            'first_name' => $request->admin_first_name,
                            'last_name' => $request->admin_last_name,
                            'email' => $request->admin_email,
                            'password' => $request->admin_first_name.'_'.$request->admin_last_name,
                        );
                        //call user model function
                        $body = UserController::email_shortcodes($template[0]->description,$args);
                        $to_email = $request->admin_email;//$request->email
                        \Mail::send([], [], function($message) use ($to_name, $to_email,$subject,$body) {
                            $message->to($to_email,$to_name)->subject($subject);
                            $message->setBody($body, 'text/html');
                            $message->from('no-reply@studentsupportsite.co.uk','Student Support Site');
                        });
                    }
                    $msg = 'Admin added Successfully';
                }

            if($request->method === 'admins_edit'){
                $admin = Admin::find($request->edit_admin_id);
                //edit admin
                $admin->first_name = $request->edit_admin_first_name;
                $admin->last_name = $request->edit_admin_last_name;
                $admin->email = $request->edit_admin_email;
                if($admin->save()){
                    //get email template by title
                    $template = AutomaticEmailController::getEmailTemplate('Update User Email Template');
                    if($template){
                        //get FROM email for user creation emails
                        $to_name  = $request->edit_admin_first_name.' '.$request->edit_admin_last_name;
                        $subject = $template[0]->subject;
                        $args = array(
                            'first_name' => $request->edit_admin_first_name,
                            'last_name' => $request->edit_admin_last_name,
                            'email' => $request->edit_admin_email,
                            'password' => $request->edit_admin_first_name.'_'.$request->edit_admin_last_name,
                            'password_reset_link' => route('password.request'),
                        );
                        //call user model function
                        $body = UserController::email_shortcodes($template[0]->description,$args);
                        $to_email = $request->edit_admin_email;//$request->email
                        \Mail::send([], [], function($message) use ($to_name, $to_email,$subject,$body) {
                            $message->to($to_email,$to_name)->subject($subject);
                            $message->setBody($body, 'text/html');
                            $message->from('no-reply@studentsupportsite.co.uk','Student Support Site');
                        });
                    }
                    $msg = 'Admin updated Successfully';
                }else{
                    $msg = 'Couldn\'t Update, Email Already Exists.';
                }
            }

            // add new tutor
            if($request->method === 'ivs'){
                //create new user for admin
                $user = new User;
                $user->name = $request->iv_first_name.' '.$request->iv_last_name; //concatenated 'first_name last_name'
                $user->username = $request->iv_email;
                $user->password = bcrypt($request->iv_first_name.'_'.$request->iv_last_name);
                $user->email = $request->iv_email;
                $user->role_id = 4;//for IV only
                $user->is_verified = 0;
                $user->save();

                $tutor = new IV;
                $tutor->user_id = $user->id;
                $tutor->first_name = $request->iv_first_name;
                $tutor->last_name = $request->iv_last_name;
                $tutor->email = $request->iv_email;
                $tutor->address = $request->iv_address;
                if($request->hasFile('iv_signature')) {
                    $file = $request->file('iv_signature');
                    //you also need to keep file extension as well
                    $name = $file->getClientOriginalName();
                    //using array instead of object
                    $image['filePath'] = $name;
                    $file->move(public_path().'/images/', $name);
                    $tutor->signature = 'images/'. $name;
                }
                $tutor->assigned_courses = $request->iv_chosen_courses_ids;
                $tutor->save();
                //get email template by title
                $template = AutomaticEmailController::getEmailTemplate('New User Creation Email');
                if($template){
                    //get FROM email for user creation emails
                    $to_name  = $request->iv_first_name.' '.$request->iv_last_name;
                    $subject = $template[0]->subject;
                    $args = array(
                        'first_name' => $request->iv_first_name,
                        'last_name' => $request->iv_last_name,
                        'email' => $request->iv_email,
                        'password' => $request->iv_first_name.'_'.$request->iv_last_name,
                    );
                    //call user model function
                    $body = UserController::email_shortcodes($template[0]->description,$args);
                    $to_email = $request->iv_email;//$request->email
                    \Mail::send([], [], function($message) use ($to_name, $to_email,$subject,$body) {
                        $message->to($to_email,$to_name)->subject($subject);
                        $message->setBody($body, 'text/html');
                        $message->from('no-reply@studentsupportsite.co.uk','Student Support Site');
                    });
                }
                $msg = 'IV Added Successfully';
            }

            //updating tutor
            if($request->method === 'ivs_edit') {
                $iv = IV::find($request->edit_iv_id);
                $iv->first_name = $request->edit_iv_first_name;
                $iv->last_name = $request->edit_iv_last_name;
                $iv->email = $request->edit_iv_email;
                $iv->address = $request->edit_iv_address;
                if($request->hasFile('edit_iv_signature')) {
                    $file = $request->file('edit_iv_signature');
                    //you also need to keep file extension as well
                    $name = $file->getClientOriginalName();
                    //using array instead of object
                    $image['filePath'] = $name;
                    $file->move(public_path().'/images/', $name);
                    $iv->signature = 'images/'. $name;
                }
                $iv->assigned_courses = $request->edit_iv_chosen_courses_ids;
                if($iv->save()){
                    //get email template by title
                    $template = AutomaticEmailController::getEmailTemplate('Settings for IV creation email');
                    if($template){
                        //get FROM email for user creation emails
                        $to_name  = $request->edit_iv_first_name.' '.$request->edit_iv_last_name;
                        $subject = $template[0]->subject;
                        $args = array(
                            'first_name' => $request->edit_iv_first_name,
                            'last_name' => $request->edit_iv_last_name,
                            'email' => $request->edit_iv_email,
                            'password' => $request->edit_iv_first_name.'_'.$request->edit_iv_last_name,
                        );
                        //call user model function
                        $body = UserController::email_shortcodes($template[0]->description,$args);
                        $to_email = $request->edit_iv_email;//$request->email
                        \Mail::send([], [], function($message) use ($to_name, $to_email,$subject,$body) {
                            $message->to($to_email,$to_name)->subject($subject);
                            $message->setBody($body, 'text/html');
                            $message->from('no-reply@studentsupportsite.co.uk','Student Support Site');
                        });
                    }
                    $msg = 'IV Updated Successfully';
                }else{
                    $msg = 'Couldn\'t Update, Email Already Exists.';
                }
            }
            return redirect()->back()->withInput()->with('message', $msg);
        }else{
            return response()->json('Request Not Valid, Please try again later.');
        }
    }

    //delete tutor
    public function removeUser(Request $request)
    {
        if($request->delete_method === 'tutors'){
            $id = $request->id;
            $msg = 'Tutor Deleted Successfully.';
            $user_id = DB::table("tutors")->where('id','=',$id)->pluck('user_id');
            DB::table("tutors")->where('id','=',$id)->delete();
            if(!empty($user_id[0])){
                DB::table("users")->where('id','=',$user_id[0])->delete();
            }
        }
        if($request->delete_method === 'admins'){
            $id = $request->admin_delete_id;
            $msg = 'Admin Deleted Successfully.';
            $user_id = DB::table("admins")->where('id','=',$id)->pluck('user_id');
            DB::table("admins")->where('id','=',$id)->delete();
            if(!empty($user_id[0])){
                DB::table("users")->where('id','=',$user_id[0])->delete();
            }
        }
        if($request->delete_method === 'ivs'){
            $id = $request->iv_delete_id;
            $msg = 'IV Deleted Successfully.';
            $user_id = DB::table("iv")->where('id','=',$id)->pluck('user_id');
            DB::table("iv")->where('id','=',$id)->delete();
            if(!empty($user_id[0])){
                DB::table("users")->where('id','=',$user_id[0])->delete();
            }
        }
        return redirect()->back()->withInput()->with('message',$msg );
    }

}
