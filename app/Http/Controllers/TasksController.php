<?php
namespace App\Http\Controllers;
use App\Roles;
use App\Student;
use Validator;
use App\User;
use App\Task;
use Carbon\Carbon;
use App\TaskMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TasksController extends Controller
{
    public function createTask(Request $request){
        $loggedin_user = Auth::user();
        if ($request->ajax()) {
            if($request->method === 'new_task'){
                $task = new Task;
                $task->subject = $request->subject;
                $task->description = $request->description;
                $task->status = 'open';
                $task->created_by = $loggedin_user->id;
                $task->assigned_to = $request->assigned_to;
                $task->priority = $request->priority;
                $task->start_date = date("Y-m-d", strtotime($request->start_date));
                $task->estimated_completion_date = date("Y-m-d", strtotime($request->end_date));
                $task->save();
                $msg = 'Task Created Successfully';
            }
            return redirect()->back()->withInput()->with('message', $msg);
        }else{
            if($request->method === 'resolve'){
                $ids = $request->resolve_ids;
                $updateDetails = [
                    'status' => 'closed',
                ];
                //update tasks by id, status to closed
                DB::table('tasks-management')
                    ->whereIn('id',explode(",",$ids))->update($updateDetails);
                $msg = 'Task(s) Status Updated';
                return redirect()->back()->withInput()->with('message', $msg);
            }

            return response()->json('Request Not Valid, Please try again later.');
        }
    }

    //view task conversation
    public function getTaskConversation($task_id){
        $logged_user = Auth::user();
        $other_user = '';
        $task = DB::table('tasks-management')
            ->select(
                DB::raw('DATE_FORMAT(start_date, "%d-%m-%Y") as start_date'),
                'created_by',
                'assigned_to',
                'id',
                'subject',
                'description',
                'status',
                'priority',
                'estimated_completion_date'
            )->where('id','=',$task_id)->first();

        $tutors = DB::table('tutors')->select('id','user_id','first_name','last_name')->orderBy('id','asc')->get();

        // to get messages from conversation, requires
        // task_id
        $messages = DB::table('conversations')->where('task_id','=',$task_id)->orderBy('id','asc')->get();

        //if logged in user is creator of task
        if($logged_user->id === $task->created_by){
            $logged_in_user_role_id = DB::table('users')->where('id','=',$task->created_by)->pluck('role_id');
            $other_user_role_id = DB::table('users')->where('id','=',$task->assigned_to)->pluck('role_id');
            $other_user_id = $task->assigned_to;
        }else{//if logged in user is NOT creator of task
            $logged_in_user_role_id = DB::table('users')->where('id','=',$task->assigned_to)->pluck('role_id');
            $other_user_role_id = DB::table('users')->where('id','=',$task->created_by)->pluck('role_id');
            $other_user_id = $task->created_by;
        }

        //get user profile info by id
        switch ($logged_in_user_role_id[0]) {
            case 1:
                $logged_in_user = DB::table('students');
                $logged_in_user_role = 'Student';
                break;
            case 2:
                $logged_in_user = DB::table('admins');
                $logged_in_user_role = 'Admin';
                break;
            case 3:
                $logged_in_user = DB::table('tutors');
                $logged_in_user_role = 'Tutor';
                break;
            case 4:
                $logged_in_user = DB::table('iv');
                $logged_in_user_role = 'IV';
                break;
        }

        //get user profile info by id
        switch ($other_user_role_id[0]) {
            case 1:
                $other_user = DB::table('students');
                $other_user_role = 'Student';
                break;
            case 2:
                $other_user = DB::table('admins');
                $other_user_role = 'Admin';
                break;
            case 3:
                $other_user = DB::table('tutors');
                $other_user_role = 'Tutor';
                break;
            case 4:
                $other_user = DB::table('iv');
                $other_user_role = 'IV';
                break;
        }

        $logged_in_user = $logged_in_user->where('user_id','=',$logged_user->id)->first();
        $other_user = $other_user->where('user_id','=',$other_user_id)->first();

            $params = array(
                'logged_in_user_role' => $logged_in_user_role,
                'other_user_role' => $other_user_role,
            );
        return view('task-management/conversations', compact('task',$task,'tutors',$tutors,'logged_in_user',$logged_in_user,'other_user',$other_user,'messages',$messages))->with($params);
    }


    // get single task based on id
    public function getTaskByIdAJAX(Request $request)
    {
        if ($request->ajax()) {
            $task = DB::table('tasks-management')
                ->select(
                    DB::raw('DATE_FORMAT(start_date, "%d/%m/%Y") as start_date'),
                    DB::raw('DATE_FORMAT(estimated_completion_date, "%d/%m/%Y") as estimated_completion_date'),
                    'created_by',
                    'assigned_to',
                    'id',
                    'subject',
                    'description',
                    'status',
                    'priority'
                )->where('id','=',$request->task_id)->get();
            return response()->json($task);
        }else{
            return response()->json('Request Not Valid, Please try again later.');
        }
    }

    //send conversation reply
    public function postReplyInConversation(Request $request){
        $logged_user = Auth::user();

        //update task
        if($request->method === 'edit_task'){
            $id = $request->task_id;
            $start_date = Carbon::parse(date("d-m-Y", strtotime($request->start_date)));
            $end_date = Carbon::parse(date("d-m-Y", strtotime($request->end_date)));
            $updateDetails = [
                'subject' => $request->subject,
                'description' => $request->description,
                'status' => $request->status,
                'created_by' => $logged_user->id,
                'assigned_to' => $request->task_assigned_to,
                'priority' => $request->priority,
                'start_date' => $start_date->format('Y-m-d'),
                'estimated_completion_date' => $end_date->format('Y-m-d'),
            ];

            //update tasks by id, status to closed
            DB::table('tasks-management')->where('id','=',$id)->update($updateDetails);
            $msg = 'Task Updated Successfully';
            return redirect()->back()->withInput()->with('message', $msg);
        }


        //get assigned_to user_id
        // start conversation messaging
        $new_message = new TaskMessage;
        $new_message->task_id = $request->task_id;
        if($logged_user->id == $request->creator_id){
            //if logged in user was task creator
            $new_message->initiator = $logged_user->id;
            $new_message->assigned_to = $request->assigned_to;
        }elseif($logged_user->id == $request->assigned_to){
            //if logged in user was NOT task creator
            $new_message->initiator = $request->assigned_to;
            $new_message->assigned_to = $logged_user->id;
        }

        $new_message->message = $request->message;
        $new_message->save();
        $msg = 'Message Posted';
        return back()->withInput()->with('message', $msg);
    }

    private $pageLimit;
    // View Tasks
    public function viewTasks($page_var,Request $request){
        $logged_in_user = Auth::user();
        $tutors = DB::table('tutors')->select('id','user_id','first_name','last_name')->orderBy('id','asc')->get();
        //$admins = DB::table('admins')->select('id','user_id','first_name','last_name')->where('user_id','<>',$logged_in_user->id)->orderBy('id','asc')->get();
        $query = DB::table('tasks-management');

           if (Auth::user()->can('view-assigned-tasks')) {
              $query = $query->where('assigned_to', '=', $logged_in_user->id);
              $query = $query->orWhere('created_by', '=', $logged_in_user->id);
           }

           if(Auth::user()->can('view-all-tasks')){
                if ($request->input('staff_filter')) {
                    $query = $query->where('assigned_to', '=', $request->input('staff_filter'));
                }
           }

        if($request->input('status_filter')){
            $query = $query->where('status','=',$request->input('status_filter'));
        }

        if($request->input('criteria_filter')){
            if($request->input('criteria_filter') === 'completion_date'){
                $query = $query->orderBy('estimated_completion_date','ASC');
            }
            if($request->input('criteria_filter') === 'start_date'){
                $query = $query->orderBy('start_date','ASC');
            }
            if($request->input('criteria_filter') === 'created_date'){
                $query = $query->orderBy('created_at','ASC');
            }
        }

        //if all filters empty, do default sorting
        if(empty($request->staff_filter AND $request->criteria_filter AND $request->criteria_filter )){
            $query = $query->orderBy('id','desc');//default sorting
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

        //$query->orderBy('created_at', 'desc');

        $tasks = $query->get();
//
        $params = [
            'total'  => $total,
            'totalPages'   => $totalPages,
            'page_var'   => $page_var,
        ];
        return view('task-management/tasks',compact('tasks' , $tasks,'tutors',$tutors))->with($params);
    }

    //delete selected tasks
    public function deleteSelectedTasks(Request $request)
    {
        $ids = $request->ids;
        DB::table("tasks-management")->whereIn('id',explode(",",$ids))->delete();
        DB::table("conversations")->whereIn('task_id',explode(",",$ids))->delete();
        return back()->withInput()->with('message', 'Task(s) Deleted');
    }
}
