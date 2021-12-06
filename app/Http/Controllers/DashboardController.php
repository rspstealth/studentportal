<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\getSetting;
use Carbon\Carbon;

class DashboardController extends Controller
{
    use getSetting;//settings trait
    //show dash
    public function showDashboard(){
        $logged_user = Auth::user();

        $total_tasks = count(DB::table('tasks-management')->where('status','=','open')->get());
        $total_low_tasks = DB::table('tasks-management')->where('status','=','open')
            ->where('priority','=','low')->get()->count();
        $total_medium_tasks = DB::table('tasks-management')->where('status','=','open')
            ->where('priority','=','medium')->get()->count();
        $total_high_tasks = DB::table('tasks-management')->where('status','=','open')
            ->where('priority','=','high')->get()->count();

        $total_courses = DB::table('courses')->get()->count();

        //if student
        if ($logged_user->role_id === 1) {
            $student_id = DB::table('students')->where('user_id', '=', $logged_user->id)->pluck('id');
            $student_my_courses_ids = DB::table('assigned_courses')
                ->where('student_id', '=', $student_id[0])
                ->where('is_completed', '=', 0)
                ->pluck('course_id');
            $student_courses = DB::table('courses')
                ->whereIn('id', $student_my_courses_ids)
                ->get();

            $student_resources = DB::table('resources')->where('is_approved','=',1)
                ->whereIn('course_specific',$student_my_courses_ids)->get();
            $total_courses_marking = array();
            $total_courses_unit_marking = array();
            $total_priority_markings = array();
        }elseif ($logged_user->role_id === 3) {//tutor
            //get tutor courses
            $tutor_courses = DB::table('tutors')->where('user_id', '=', $logged_user->id)->pluck('assigned_courses');
            $tutor_courses = explode(',', $tutor_courses);
            $priority_students = DB::table('assigned_courses')
                ->where('is_priority', '=', 1)
                ->groupBy('student_id')
                ->pluck('student_id');

            $student_ids_string = [];
            foreach ($priority_students as $id) {
                $student_ids_string[] = $id;
            }

            $days = $this->getPrintSetting('priority_students_marking_duration');
            $ten_days_back_date = Carbon::now()->subDays($days); // today date - days
            $query = DB::table('standard_courses_uploads')
                ->whereIn('course_id', $tutor_courses)
                ->whereIn('student_id', $student_ids_string)
                //->where('unit_evidence_id', '=', NULL)//get only standard courses
                ->where('created_at', '<', $ten_days_back_date->toDatetimeString())
                ->orderBy('created_at', 'asc');
            $total_priority_markings = $query->get()->count();

            $total_courses_marking = DB::table('standard_courses_uploads')
                ->select('assignment_number')->groupBy('assignment_number')
                ->whereIn('course_id', $tutor_courses)
                ->where('status', '=', 'awaiting_feedback')
                ->where('unit_evidence_id', '=', NULL)//get only standard courses
                ->get()->count();
            $total_courses_unit_marking = DB::table('standard_courses_uploads')
                ->select('student_id')->groupBy('student_id')
                ->whereIn('course_id', $tutor_courses)
                ->where('status', '<>', 'pass')
                ->where('assignment_number', '=', NULL)//get only unit based courses
                ->get()->count();
            $student_courses = array();
            $student_resources = array();
        }else{
            $student_courses = array();
            $student_resources = array();
            $total_courses_marking = array();
            $total_courses_unit_marking = array();
            $total_priority_markings = array();
        }

        $total_materials = DB::table('materials')->get()->count();
        $total_resources = DB::table('resources')->get()->count();


        $total_students = DB::table('students')->get()->count();
        $total_tutors = DB::table('tutors')->get()->count();
        $total_admins = DB::table('admins')->get()->count();
        $total_ivs = DB::table('iv')->get()->count();


        $params = [
            'total_tasks'        => $total_tasks,
            'total_low_tasks'    => $total_low_tasks,
            'total_medium_tasks' => $total_medium_tasks,
            'total_high_tasks'   => $total_high_tasks,
            'total_courses'      => $total_courses,
            'student_courses'    => $student_courses,
            'student_resources'  => $student_resources,
            'total_courses_marking'  => $total_courses_marking,
            'total_courses_unit_marking'  => $total_courses_unit_marking,
            'total_priority_markings'  => $total_priority_markings,
            'total_materials'    => $total_materials,
            'total_resources'    => $total_resources,
            'total_students'     => $total_students,
            'total_tutors'       => $total_tutors,
            'total_admins'       => $total_admins,
            'total_ivs'          => $total_ivs,
        ];


        //get desired user data
        switch ($logged_user->role_id) {
            case 1:
                return view('dashboard/student-dashboard')->with($params);
                break;
            case 2:
                return view('dashboard/dashboard')->with($params);
                break;
            case 3:
                return view('dashboard/tutor-dashboard')->with($params);
                break;
            case 4:
                return view('dashboard/iv-dashboard')->with($params);
                break;
        }


    }



}
