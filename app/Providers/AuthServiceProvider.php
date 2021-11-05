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
        Gate::define('show', function (RegisteredUsers $registeredUsers ) {
            if( $registeredUsers->role_id == 1 || $registeredUsers->role_id ==2){
                return true;
            }
        });
        Gate::define('create', function (RegisteredUsers $registeredUsers ) {
            if( $registeredUsers->role_id == 1 || $registeredUsers->role_id ==2){
                return true;
            }
        });
        Gate::define('update', function (RegisteredUsers $registeredUsers ) {
            if( $registeredUsers->role_id == 1 || $registeredUsers->role_id ==2){
                return true;
            }
        });
        Gate::define('delete', function (RegisteredUsers $registeredUsers ) {
            if( $registeredUsers->role_id == 1 || $registeredUsers->role_id ==2){
                return true;
            }
        });
// Recruiters
        Gate::define('show-admin', function (RegisteredUsers $registeredUsers ) {
            if( $registeredUsers->role_id == 1 ){
                return true;
            }
        });
        Gate::define('create-admin', function (RegisteredUsers $registeredUsers ) {
            if( $registeredUsers->role_id == 1 ){
                return true;
            }
        });
        Gate::define('update-admin', function (RegisteredUsers $registeredUsers ) {
            if( $registeredUsers->role_id == 1 ){
                return true;
            }
        });
        Gate::define('delete-admin', function (RegisteredUsers $registeredUsers ) {
            if( $registeredUsers->role_id == 1 ){
                return true;
            }
        });

        Gate::define('show-all', function (RegisteredUsers $registeredUsers ) {
            if( $registeredUsers->role_id == 1 || $registeredUsers->role_id ==2){
                return true;
            }
        });
        Gate::define('create-all', function (RegisteredUsers $registeredUsers ) {
            if( in_array($registeredUsers->role_id,[1,2,3])){
                return true;
            }
        });
        Gate::define('update-all', function (RegisteredUsers $registeredUsers ) {
            if( in_array($registeredUsers->role_id,[1,2,3])){
                return true;
            }
        });
        Gate::define('delete-all', function (RegisteredUsers $registeredUsers ) {
            if( in_array($registeredUsers->role_id,[1,2,3])){
                return true;
            }
        });
    }
}
