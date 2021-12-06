<?php
namespace App\Traits;
use Illuminate\Database\Eloquent\Model;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;

trait getSetting {
    //get setting from DB
    public function getPrintSetting($label) {
            $setting_value = DB::table('settings')->select('value')
                ->where('label','=',$label)
                ->first();
            return $setting_value->value;
    }
}
