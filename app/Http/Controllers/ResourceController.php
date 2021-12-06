<?php
namespace App\Http\Controllers;
use App\Roles;
use App\Student;
use App\Course;
use App\Resource;
use Validator;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ResourceController extends Controller
{
    public function createResource(Request $request){
        if ($request->ajax()) {
            if($request->method === 'new_resource'){
                $resource = new Resource;
                if($request->course_specific === 'all'){
                    $resource->course_specific = 'all';
                }elseif($request->course_specific === 'course_specific'){
                    $resource->course_specific = $request->course_id;
                }

                $logged_user = Auth::user();
                //get desired user data
                if ($logged_user->role_id === 1) {
                    $resource->is_approved = 0;
                }

                $file = $request->file('resource_file');
                $name = $file->getClientOriginalName();
                $file->move(public_path().'/resources/', $name);
                $resource->resource_file = $name;
                $resource->description = $request->description;
                $resource->save();
                $msg = 'Resource Created Successfully';
            }
            return redirect()->back()->withInput()->with('message', $msg);
        }
    }


    private $pageLimit;
    // View Resources
    public function viewResources($page_var,Request $request){
        //get courses
        $courses = DB::table('courses')->orderBy('name','asc')->get();

        $query = DB::table('resources')->where('is_approved','=',1);

        //limit resources to student's courses only
        $logged_user = Auth::user();
        //get desired user data
        if ($logged_user->role_id === 1) {
            //get student id from user id
            $user_id = DB::table('students')->where('user_id','=',$logged_user->id)->pluck('id');
            //get student's courses
            $assigned_courses = DB::table('assigned_courses')->where('student_id','=',$user_id[0])->pluck('course_id');
            $student_course_ids_string= [];
            foreach($assigned_courses as $course_id){
                $student_course_ids_string[] = $course_id;
            }
            $query = $query->whereIn('course_specific',$student_course_ids_string)
                           ->orWhere('course_specific','=','all');
        }

        if($request->input('accessibility_filter') === 'course'){
            if($request->input('single_course_search')){
                $query = $query->where('course_specific','=',$request->searched_course_id);
            }
        }

        if($request->input('accessibility_filter') === 'unit') {
            //$query = $query->where('course_specific','=',);
        }

        $query = $query->orderBy('id','DESC');

        $total = $query->count();

        $this->pageLimit = 20;
        //get page limit from the form post variable
        if($this->pageLimit === 20){
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

        $resources = $query->get();
        $params = [
            'total'  => $total,
            'totalPages'   => $totalPages,
            'page_var'   => $page_var,
        ];
        return view('resources/resources',compact('resources' , $resources,'courses',$courses))->with($params);
    }

    //delete selected resources
    public function deleteSelectedResources(Request $request)
    {
        $ids = $request->ids;
        DB::table("resources")->whereIn('id',explode(",",$ids))->delete();
        return back()->withInput()->with('message', 'Resource(s) Deleted');
    }
}
