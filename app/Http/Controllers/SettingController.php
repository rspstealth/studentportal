<?php
namespace App\Http\Controllers;
use App\Admin;
use App\Setting;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    //get all system settings
    public function getSystemSettingsPage(){
        $settings = DB::table('settings')->get();
        $params = array();
        foreach($settings as $setting){
            //echo $setting->label;
            $params[$setting->label] = $setting->value;
        }
        return view('settings/system-settings')->with($params);
    }

    //update system settings
    public function updateSystemSettings(Request $request){
        if ($request->ajax()) {
            foreach($request->all() as $key=>$value){
                if($key !== '_token'){
                    $key_exists = DB::table('settings')->where('label','=',$key)->first();
                   if(!empty($key_exists)){
                       $update = Setting::where('label','=',$key)
                           ->update(['value' => $value]);
                   }else{
                       $new_setting = new Setting;
                       $new_setting->label = $key;
                       $new_setting->value = $value;
                       $new_setting->save();
                   }
                }
            }
            return 'Success';
        }else{
            return response()->json($request->all());
        }
    }

}
