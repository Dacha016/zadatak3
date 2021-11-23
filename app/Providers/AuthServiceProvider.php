<?php

namespace App\Providers;

use App\Models\LoggedInUser;
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

    // Admins
         Gate::define('admin', fn (LoggedInUser $loggedInUser) => $loggedInUser->role_id == 1);


    // Recruiter-Admin
        Gate::define('admin-recruiter', fn (LoggedInUser $loggedInUser) => in_array($loggedInUser->role_id,[1,2]));

    //All
        Gate::define('admin-recruiter-mentor', fn (LoggedInUser $loggedInUser) => in_array($loggedInUser->role_id,[1,2,3]));
    }
}
