<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username','email', 'password','role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function hasAccess(string $permission){
        //allow everything to admin
//        if($this->role_id === 2){
//            return true;
//        }

        //check other user permissions to allow access
        $permissions = DB::table('roles')->where('id','=',$this->role_id)->pluck('permissions');
        $permissions = explode(",",$permissions[0]);

        foreach($permissions as $perm){
            if($perm == $permission){
                return true;
            }
        }
        return false;
    }
}
