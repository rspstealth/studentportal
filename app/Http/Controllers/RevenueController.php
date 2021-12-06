<?php
namespace App\Http\Controllers;
use App\Traits\getSetting;
use App\Revenue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class RevenueController extends Controller
{
    use getSetting;//settings trait

    public function generate_pdf(Request $request) {
        $logged_in_user = Auth::user();
        $tutor_id = DB::table('tutors')->where('user_id','=',$logged_in_user->id)->pluck('id');
        //get tutor added revenues list
        $query = DB::table('revenue')->where('tutor_id','=',$tutor_id[0]);
        if(!empty($request->input('from_date')) ){
            if(!empty($request->input('estimated_completion_date'))){
                $from = date("Y-m-d", strtotime($request->input('from_date')));
                $to = date("Y-m-d", strtotime($request->input('estimated_completion_date')));
                $query = $query->whereBetween('date', [$from, $to]);
            }
        }
        $query->orderBy('created_at', 'asc');
        $revenues = $query->get();
        //$price_format = $this->getPrintSetting('price_format');
//        $params = [
//            'price_format' => $this->getPrintSetting('price_format')
//        ];
        view()->share('revenues',$revenues);
        $pdf = PDF::loadView('revenue.pdf', $revenues);
        return $pdf->stream('revenue.pdf');
    }

    // new addNewSaleOrCreditEntry
    public function addNewSaleOrCreditEntry($page_var,Request $request){
        //if ajax request
        $logged_in_user = Auth::user();//get user
        $tutor_id = DB::table('tutors')->where('user_id','=',$logged_in_user->id)->pluck('id');

        $revenue = new Revenue;
        $revenue->tutor_id =  $tutor_id[0];
        $revenue->description = $request->description;
        if($request->entry_type === 'sale'){
            $revenue->entry_type = 'sale';
        }
        if($request->entry_type === 'credit'){
            $revenue->entry_type = 'credit';
            $revenue->student_number = $request->student_number;
        }
        $revenue->cost = $request->cost;
        $revenue->date = date("Y-m-d", strtotime($request->invoice_date));
        $revenue->save();
        if($revenue){
            return redirect()->back()->withInput()->with('message', 'Success');
        }else{
            return redirect()->back()->withInput()->with('error', 'There was a problem, please try again.');
        }
    }

    private $pageLimit;
    // get Tutor Revenue
    public function getTutorRevenue($page_var,Request $request){
        $logged_in_user = Auth::user();
        $tutor_id = DB::table('tutors')->where('user_id','=',$logged_in_user->id)->pluck('id');
        //get tutor added revenues list
        $query = DB::table('revenue')->where('tutor_id','=',$tutor_id[0]);


        if(!empty($request->input('from_date')) ){
            if(!empty($request->input('estimated_completion_date'))){
                $from = date("Y-m-d", strtotime($request->input('from_date')));
                $to = date("Y-m-d", strtotime($request->input('estimated_completion_date')));
                $query = $query->whereBetween('date', [$from, $to]);
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
        $query->orderBy('created_at', 'asc');
        $revenues = $query->get();
        $params = [
            'total'  => $total,
            'totalPages'   => $totalPages,
            'page_var'   => $page_var,
        ];
        return view('revenue/list',compact('revenues', $revenues))->with($params);
    }

    //delete sale or credit entry
    public function RemoveSaleOrCreditEntry(Request $request){
        $id = $request->id;
        DB::table("revenue")->where('id','=',$id)->delete();
        return back()->withInput()->with('message', 'success');
    }
}