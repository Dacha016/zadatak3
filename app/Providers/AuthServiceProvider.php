<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\LoggedInUser;
use App\Models\Mentor;
use App\Models\Recruiter;
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

    // Admin-Recruiter
        Gate::define('admin', fn (LoggedInUser $loggedInUser) => $loggedInUser->role_id === 1);
        Gate::define('admin-own', function( LoggedInUser $loggedInUser,$id){
            $admin=Admin::where("id",$id)->first()->toArray();
            return  $loggedInUser->email==$admin["email"];
        });
        Gate::define('update-recruiter', function( LoggedInUser $loggedInUser,$id){
            $recruiter=Recruiter::where("id",$id)->first()->toArray();
            return $loggedInUser->role_id === 1 || $loggedInUser->email==$recruiter["email"];
        } );
    //Mentor
        Gate::define('admin-recruiter', fn (LoggedInUser $loggedInUser) => in_array($loggedInUser->role_id,[1,2]));
        Gate::define('update-mentor', function( LoggedInUser $loggedInUser,$id){
            $mentor=Mentor::where("id",$id)->first()->toArray();
            return  in_array($loggedInUser->role_id,[1,2]) || $loggedInUser->email==$mentor["email"];
        } );
        Gate::define('mentor', fn (LoggedInUser $loggedInUser) => $loggedInUser->role_id === 3);
    //All
        Gate::define('admin-recruiter-mentor', fn (LoggedInUser $loggedInUser) => in_array($loggedInUser->role_id,[1,2,3]));
    }
}
