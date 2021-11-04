<?php

namespace App\Providers;

use App\Models\Admin;

use App\Models\Mentor;
use App\Models\RegisteredUsers;
use App\Policies\MentorPolicy;


use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [


        // 'App\Models\Model' => 'App\Policies\ModelPolicy',


    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

// mentors
    Gate::define('show-mentor', function (RegisteredUsers $registeredUsers ) {
        if( $registeredUsers->role_id == 1 || $registeredUsers->role_id ==2){
            return true;
        }
    });
        Gate::define('create-mentor', function (RegisteredUsers $registeredUsers ) {
            if( $registeredUsers->role_id == 1 || $registeredUsers->role_id ==2){
                return true;
            }
        });
        Gate::define('update-mentor', function (RegisteredUsers $registeredUsers ) {
            if( $registeredUsers->role_id == 1 || $registeredUsers->role_id ==2){
                return true;
            }
        });
        Gate::define('delete-mentor', function (RegisteredUsers $registeredUsers ) {
            if( $registeredUsers->role_id == 1 || $registeredUsers->role_id ==2){
                return true;
            }
        });
// Recruiters
    Gate::define('show-recruiter', function (RegisteredUsers $registeredUsers ) {
        if( $registeredUsers->role_id == 1 ){
            return true;
        }
    });
        Gate::define('create-recruiter', function (RegisteredUsers $registeredUsers ) {
            if( $registeredUsers->role_id == 1 ){
                return true;
            }
        });
        Gate::define('update-recruiter', function (RegisteredUsers $registeredUsers ) {
            if( $registeredUsers->role_id == 1 ){
                return true;
            }
        });
        Gate::define('delete-recruiter', function (RegisteredUsers $registeredUsers ) {
            if( $registeredUsers->role_id == 1 ){
                return true;
            }
        });


    }
}
