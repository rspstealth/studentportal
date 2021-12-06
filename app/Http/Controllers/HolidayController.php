<?php
namespace App\Http\Controllers;
use App\Holiday;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HolidayController extends Controller
{

    // new staff holiday
    public function newHoliday($page_var,Request $request){
        //if ajax request
            $logged_in_user = Auth::user();//get user
            $new_holiday = new Holiday;
            $new_holiday->tutor_id =  $request->tutor_name;
            $new_holiday->message = $request->message;
            $new_holiday->from_date = Carbon::createFromFormat('d/m/Y', $request->from_date)->format('Y-m-d');
            $new_holiday->to_date = Carbon::createFromFormat('d/m/Y', $request->to_date)->format('Y-m-d');
            $new_holiday->created_by = $logged_in_user->id;
            $new_holiday->save();
            if($new_holiday){
                return redirect()->back()->withInput()->with('message', 'Holiday Assigned');
            }else{
                return redirect()->back()->withInput()->with('error', 'There was a problem assigning holiday, please try again.');
            }
    }

    // new staff holidays request
    public function getNewHolidays(){
        return view('staff-holidays/new-request');
    }

    // new staff holiday Request
    public function requestNewHolidays(Request $request){
        //if ajax request
        $logged_in_user = Auth::user();//get user
        $new_holiday = new Holiday;
        $new_holiday->tutor_id =  $logged_in_user->id;
        $new_holiday->message = $request->message;
        $new_holiday->from_date = date("Y-m-d", strtotime($request->from_date));
        $new_holiday->to_date = date("Y-m-d", strtotime($request->to_date));
        $new_holiday->created_by = $logged_in_user->id;
        $new_holiday->save();

        if($new_holiday){
            return redirect()->back()->withInput()->with('message', 'Holidays Request Submitted');
        }else{
            return redirect()->back()->withInput()->with('error', 'There was a problem requesting holidays, please try again.');
        }
    }

    private $pageLimit;

    // get all holidays
    public function getHolidays($page_var,Request $request){
        //get all tutors
        $tutors = DB::table('tutors')->select('id','first_name','last_name')->orderBy('first_name','asc')->get();

        $query = DB::table('staff_holidays')->select();
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

        $holidays = $query->get();

        $holiday_tutor_names = [];
        foreach($holidays as $holiday){
            foreach($tutors as $tutor){
                if($tutor->id == $holiday->tutor_id){
                    //print "$tutor->id == $holiday->tutor_id, ";
                    $holiday_tutor_names[$tutor->id] = $tutor->first_name.' '.$tutor->last_name;
                }
            }
        }


        $params = [
            'total'  => $total,
            'totalPages'   => $totalPages,
            'page_var'   => $page_var,
            'holiday_tutor_names' => $holiday_tutor_names,
        ];
        return view('staff-holidays/list',compact('holidays', $holidays,'tutors', $tutors ))->with($params);
    }

    public function removeHoliday(Request $request){
        $id = $request->id;
        DB::table("staff_holidays")->where('id','=',$id)->delete();
        return back()->withInput()->with('message', 'success');
    }
}
