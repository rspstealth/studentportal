<?php
namespace App\Http\Controllers;
use App\Admin;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StatsController extends Controller
{
    //get all stats
    public function getStats(){
//        $settings = DB::table('settings')->get();
//        $params = array();
//        foreach($settings as $setting){
//            //echo $setting->label;
//            $params[$setting->label] = $setting->value;
//        }
        //return view('settings/system-settings')->with($params);
        return view('stats/stats');
    }
}
