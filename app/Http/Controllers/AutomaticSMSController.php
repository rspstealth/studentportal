<?php
namespace App\Http\Controllers;
use App\Traits\getSetting;
use App\Roles;
use App\Student;
use App\Course;
use App\AutomaticSMS;
use Validator;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Exception;
use Twilio\Rest\Client;

class AutomaticSMSController extends Controller
{
    use getSetting;//settings trait

    public function sendSMS(){
            $receiverNumber = "+923113399864";
            $message = "This is testing from sandbox";

            try {
                //get twilio credentials
                $account_sid   = $this->getPrintSetting('twilio_account_sid');
                $auth_token    = $this->getPrintSetting('twilio_auth_token');
                $twilio_number = $this->getPrintSetting('twilio_number');

                $client = new Client($account_sid, $auth_token);
                $client->messages->create($receiverNumber, [
                    'from' => $twilio_number,
                    'body' => $message]);
                dd('SMS Sent Successfully.');
            } catch (Exception $e) {
            dd("Error: ". $e->getMessage());
        }
    }

    //get sms template
    public static function getSMSTemplate($sms_template_title){
        $sms_types = DB::table('automatic_sms')->select('title')->where('is_active','=',1)->get()->toArray();
        foreach($sms_types as $template){
            if($template->title === $sms_template_title){
                $sms_template_data = DB::table('automatic_sms')->where('title','=',$sms_template_title)->get();
                return $sms_template_data;
            }
        }
        return;
    }

    // check if unique template title
    public function checkIfSMSTemplateAlreadyExistsAJAX(Request $request)
    {
        if ($request->ajax()) {
            $template_exists = DB::table('automatic_sms')->where('title','=',$request->title)->pluck('id');
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
            $template = DB::table('automatic_sms')->where('id','=',$request->edit_template_id)->first();
            return response()->json($template);
        }else{
            return response()->json($request->all());
        }
    }

    public function createAutomaticSMS(Request $request){
        if ($request->ajax()) {
            if($request->method === 'new_sms_template'){
                $template = new AutomaticSMS;
                $template->title = $request->title;
                $template->sms = $request->sms;
                $template->is_active = $request->is_active;
                $template->save();
                $msg = 'Template Created Successfully';
            }

            if($request->method === 'edit_sms_template'){
                $template = AutomaticSMS::find($request->edit_template_id);
                $template->title = $request->edit_title;
                $template->sms = $request->edit_sms;
                $template->is_active = $request->edit_is_active;
                $template->save();
                $msg = 'Template Created Successfully';
            }
            return redirect()->back()->withInput()->with('message', $msg);
        }
    }

    private $pageLimit;
    // View Resources
    public function viewAutomaticSMS($page_var,Request $request){
        //get courses
        $query = DB::table('automatic_sms');

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

        $automatic_sms = $query->get();
        $params = [
            'total'  => $total,
            'totalPages'   => $totalPages,
            'page_var'   => $page_var,
        ];
        return view('communication/automatic-sms',compact('automatic_sms' , $automatic_sms))->with($params);
    }

    //delete selected email templates
    public function deleteAutomaticSMS(Request $request)
    {
        $ids = $request->ids;
        DB::table("automatic_sms")->whereIn('id',explode(",",$ids))->delete();
        return back()->withInput()->with('message', 'Template(s) Deleted');
    }
}
