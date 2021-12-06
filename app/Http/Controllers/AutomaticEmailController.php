<?php
namespace App\Http\Controllers;
use App\Roles;
use App\Student;
use App\Course;
use App\AutomaticEmail;
use Validator;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AutomaticEmailController extends Controller
{
    //get email template
    public static function getEmailTemplate($email_template_title){
        $email_types = DB::table('automatic_emails')->select('title')->where('is_active','=',1)->get()->toArray();
        foreach($email_types as $template){
            if($template->title === $email_template_title){
                $email_template_data = DB::table('automatic_emails')->where('title','=',$email_template_title)->get();
                return $email_template_data;
            }
        }
        return;
    }

    // check if unique template title
    public function checkIfEmailTemplateAlreadyExistsAJAX(Request $request)
    {
        if ($request->ajax()) {
            $template_exists = DB::table('automatic_emails')->where('title','=',$request->title)->pluck('id');
            if(empty($template_exists[0])){
                return response()->json('unique');
            }else{
                return response()->json('exists');
            }
        }else{
            return response()->json($request->all());
        }
    }

    // get template by id
    public function getTemplatebyIdAJAX(Request $request)
    {
        if ($request->ajax()) {
            $template = DB::table('automatic_emails')->where('id','=',$request->edit_template_id)->get();
            return response()->json($template[0]);
        }else{
            return response()->json($request->all());
        }
    }

    public function createAutomaticEmail(Request $request){
        if ($request->ajax()) {
            if($request->method === 'new_email_template'){
                $template = new AutomaticEmail;
                $template->title = $request->title;
                $template->subject = $request->subject;
                $template->is_active = $request->is_active;
                $template->description = $request->description;
                $template->save();
                $msg = 'Template Created Successfully';
            }

            if($request->method === 'edit_email_template'){
                $template = AutomaticEmail::find($request->edit_template_id);
                $template->title = $request->edit_title;
                $template->subject = $request->edit_subject;
                $template->is_active = $request->edit_is_active;
                $template->description = $request->edit_description;
                $template->save();
                $msg = 'Template Created Successfully';
            }
            return redirect()->back()->withInput()->with('message', $msg);
        }
    }

    private $pageLimit;
    // View Resources
    public function viewAutomaticEmails($page_var,Request $request){
        //get courses
        $query = DB::table('automatic_emails');

        if($request->input('template_status_filter')){
            if($request->input('template_status_filter') === 'active') {
                $query = $query->where('is_active','=',1);
            }
            if($request->input('template_status_filter') === 'inactive') {
                $query = $query->where('is_active','=',0);
            }
        }

        $query = $query->orderBy('title','ASC');
        $total = $query->count();

        $this->pageLimit = 30;
        //get page limit from the form post variable
        if($this->pageLimit === 30){
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

        $automatic_emails = $query->get();
        $params = [
            'total'  => $total,
            'totalPages'   => $totalPages,
            'page_var'   => $page_var,
        ];
        return view('communication/automatic-emails',compact('automatic_emails' , $automatic_emails))->with($params);
    }

    //delete selected resources
    public function deleteAutomaticEmails(Request $request)
    {
        $ids = $request->ids;
        DB::table("automatic_emails")->whereIn('id',explode(",",$ids))->delete();
        return back()->withInput()->with('message', 'Template(s) Deleted');
    }
}
