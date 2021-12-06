<?php

namespace App\Providers;
use App\Student;
use App\Roles;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->userPolicies();
    }

    public function userPolicies()
    {
        //tasks
        Gate::define('create-tasks',function (User $user){
            return $user->hasAccess('create-tasks');
        });
        Gate::define('edit-tasks',function (User $user){
            return $user->hasAccess('edit-tasks');
        });
        Gate::define('view-all-tasks',function (User $user){
            return $user->hasAccess('view-tasks');
        });
        Gate::define('view-assigned-tasks',function (User $user){
            return $user->hasAccess('view-assigned-tasks');
        });
        Gate::define('staff-filter-tasks',function (User $user){
            return $user->hasAccess('staff-filter-tasks');
        });
        Gate::define('delete-tasks',function (User $user){
            return $user->hasAccess('delete-tasks');
        });

        Gate::define('my-courses',function (User $user){
            return $user->hasAccess('my-courses');
        });

        Gate::define('create-resources',function (User $user){
            return $user->hasAccess('create-resources');
        });
        Gate::define('delete-resources',function (User $user){
            return $user->hasAccess('delete-resources');
        });

        Gate::define('create-materials',function (User $user){
            return $user->hasAccess('create-materials');
        });
        Gate::define('delete-materials',function (User $user){
            return $user->hasAccess('delete-materials');
        });

        Gate::define('create-contact-reason',function (User $user){
            return $user->hasAccess('create-contact-reason');
        });

//        Gate::define('filter-resources',function (User $user){
//            return $user->hasAccess('filter-resources');
//        });




    }

}
