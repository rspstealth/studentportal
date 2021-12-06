<?php
namespace App\Http\Controllers;
use App\Roles;
use App\Student;
use Validator;
use App\User;
use App\HelpCentre;
use App\ContactReason;
use Carbon\Carbon;
use App\HelpCentreMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class HelpCentreController extends Controller
{
    public function createHelpCentreTask(Request $request){
        $loggedin_user = Auth::user();
        if ($request->ajax()) {
            if($request->method === 'new_helpcentre'){
                $helpcentre = new HelpCentre;
                $helpcentre->subject = $request->subject;
                $helpcentre->description = $request->description;
                $helpcentre->status = 'open';
                $helpcentre->created_by = $loggedin_user->id;
                $helpcentre->assigned_to = $request->assigned_to;
                $helpcentre->priority = $request->priority;
                $helpcentre->start_date = date("Y-m-d", strtotime($request->start_date));
                $helpcentre->estimated_completion_date = date("Y-m-d", strtotime($request->end_date));
                $helpcentre->save();
                $msg = 'HelpCentre Created Successfully';
            }
            return redirect()->back()->withInput()->with('message', $msg);
        }else{
            if($request->method === 'resolve'){
                $ids = $request->resolve_ids;
                $updateDetails = [
                    'status' => 'closed',
                ];
                //update helpcentres by id, status to closed
                DB::table('help-centre')
                    ->whereIn('id',explode(",",$ids))->update($updateDetails);
                $msg = 'HelpCentre(s) Status Updated';
                return redirect()->back()->withInput()->with('message', $msg);
            }

            return response()->json('Request Not Valid, Please try again later.');
        }
    }

    public function createContactReason(Request $request){
        $loggedin_user = Auth::user();
        if ($request->ajax()) {
                $contact_reason = new ContactReason;
                $contact_reason->reason = $request->reason;
                $contact_reason->priority = $request->priority;
                $contact_reason->assigned_staff = $request->assigned_staff;
                $contact_reason->save();
                $msg = 'Contact Reason Created Successfully';
            return redirect()->back()->withInput()->with('message', $msg);
        }
    }

    //view help centre contact reasons
    public function getContactReasons(Request $request){
        $contact_reasons = DB::table('contact-reasons')->orderBy('reason','asc')->get();
        return view('help-centre/contact-reasons',compact('contact_reasons',$contact_reasons));
    }

    // get single helpcentre based on id
    public function getHelpCentreByIdAJAX(Request $request)
    {
        if ($request->ajax()) {
            $helpcentre = DB::table('help-centre')
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
                )->where('id','=',$request->helpcentre_id)->get();
            return response()->json($helpcentre);
        }else{
            return response()->json('Request Not Valid, Please try again later.');
        }
    }

    //send conversation reply
    public function postReplyInConversation(Request $request){
        $logged_user = Auth::user();

        //update helpcentre
        if($request->method === 'edit_helpcentre'){
            $id = $request->helpcentre_id;
            $start_date = Carbon::parse(date("d-m-Y", strtotime($request->start_date)));
            $end_date = Carbon::parse(date("d-m-Y", strtotime($request->end_date)));
            $updateDetails = [
                'subject' => $request->subject,
                'description' => $request->description,
                'status' => $request->status,
                'created_by' => $logged_user->id,
                'assigned_to' => $request->helpcentre_assigned_to,
                'priority' => $request->priority,
                'start_date' => $start_date->format('Y-m-d'),
                'estimated_completion_date' => $end_date->format('Y-m-d'),
            ];

            //update helpcentres by id, status to closed
            DB::table('help-centre')->where('id','=',$id)->update($updateDetails);
            $msg = 'HelpCentre Updated Successfully';
            return redirect()->back()->withInput()->with('message', $msg);
        }


        //get assigned_to user_id
        // start conversation messaging
        $new_message = new HelpCentreMessage;
        $new_message->helpcentre_id = $request->helpcentre_id;
        if($logged_user->id == $request->creator_id){
            //if logged in user was helpcentre creator
            $new_message->initiator = $logged_user->id;
            $new_message->assigned_to = $request->assigned_to;
        }elseif($logged_user->id == $request->assigned_to){
            //if logged in user was NOT helpcentre creator
            $new_message->initiator = $request->assigned_to;
            $new_message->assigned_to = $logged_user->id;
        }

        $new_message->message = $request->message;
        $new_message->save();
        $msg = 'Message Posted';
        return back()->withInput()->with('message', $msg);
    }

    private $pageLimit;
    // View HelpCentres
    public function viewHelpCentreTask($page_var,Request $request){
        $logged_in_user = Auth::user();
        $students = DB::table('students')->select('id','user_id','first_name','last_name')->orderBy('id','asc')->get();
        //$admins = DB::table('admins')->select('id','user_id','first_name','last_name')->where('user_id','<>',$logged_in_user->id)->orderBy('id','asc')->get();
        $query = DB::table('help-centre');

           if (Auth::user()->can('view-assigned-helpcentres')) {
              $query = $query->where('assigned_to', '=', $logged_in_user->id);
              $query = $query->orWhere('created_by', '=', $logged_in_user->id);
           }

           if(Auth::user()->can('view-all-helpcentres')){
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
        return view('help-centre/help-centre',compact('tasks' , $tasks,'students',$students))->with($params);
    }

    //delete selected help centre tasks
    public function deleteSelectedHelpCentreTasks(Request $request)
    {
        $ids = $request->ids;
        DB::table("help-centre")->whereIn('id',explode(",",$ids))->delete();
        DB::table("help-centre-conversations")->whereIn('help_centre_id',explode(",",$ids))->delete();
        return back()->withInput()->with('message', 'Task(s) Deleted');
    }
}
