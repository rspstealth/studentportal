<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class ImpersonateController extends Controller
{
    //impersonate as another user
    public function Impersonate($id){
        $user = User::where('id',$id)->first();
        if($user){
            session()->put('impersonate',$user->id);
        }
        return redirect('/dashboard');
    }

    //stop impersonating as another user
    public function Destroy(){
        session()->forget('impersonate');
        return redirect('/dashboard');
    }
}
