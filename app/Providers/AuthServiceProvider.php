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

    // Admins
        Gate::define('admin', fn (RegisteredUsers $registeredUsers) => $registeredUsers->role_id == 1);

    // Recruiter-Admin
        Gate::define('admin-recruiter', fn (RegisteredUsers $registeredUsers) => in_array($registeredUsers->role_id,[1,2]));

    //All
        Gate::define('admin-recruiter-mentor', fn (RegisteredUsers $registeredUsers) => in_array($registeredUsers->role_id,[1,2,3]));
    }
}
