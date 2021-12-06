<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use App\User;

class BladeExtraServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Blade::if('impersonate',function(){
           if(session()->get('impersonate')){
               return true;
           }
           return false;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
