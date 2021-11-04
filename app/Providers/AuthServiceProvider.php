<?php

namespace App\Providers;

use App\Models\RegisteredUsers;
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
        Gate::define('show', function (RegisteredUsers $registeredUsers ) {
            if( $registeredUsers->role_id == 1 ){
                return true;
            }
        });
        Gate::define('create', function (RegisteredUsers $registeredUsers ) {
            if( $registeredUsers->role_id == 1 ){
                return true;
            }
        });
        Gate::define('update', function (RegisteredUsers $registeredUsers ) {
            if( $registeredUsers->role_id == 1 ){
                return true;
            }
        });
        Gate::define('delete', function (RegisteredUsers $registeredUsers ) {
            if( $registeredUsers->role_id == 1 ){
                return true;
            }
        });
    }
}
