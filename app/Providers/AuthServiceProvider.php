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

// Recruiter-Admin
        Gate::define('show', fn (RegisteredUsers $registeredUsers) => in_array($registeredUsers->role_id,[1,2]));
        Gate::define('create', fn (RegisteredUsers $registeredUsers) => in_array($registeredUsers->role_id,[1,2]));
        Gate::define('update', fn (RegisteredUsers $registeredUsers) => in_array($registeredUsers->role_id,[1,2]));
        Gate::define('delete', fn (RegisteredUsers $registeredUsers) => in_array($registeredUsers->role_id,[1,2]));
// Admins
        Gate::define('show-admin', fn (RegisteredUsers $registeredUsers) => $registeredUsers->role_id == 1);
        Gate::define('create-admin', fn (RegisteredUsers $registeredUsers) => $registeredUsers->role_id == 1);
        Gate::define('update-admin', fn (RegisteredUsers $registeredUsers) => $registeredUsers->role_id == 1);
        Gate::define('delete-admin', fn (RegisteredUsers $registeredUsers) => $registeredUsers->role_id == 1);
//All
        Gate::define('show-all', fn (RegisteredUsers $registeredUsers) => in_array($registeredUsers->role_id,[1,2,3]));
        Gate::define('create-all', fn (RegisteredUsers $registeredUsers) => in_array($registeredUsers->role_id,[1,2,3]));
        Gate::define('update-all', fn (RegisteredUsers $registeredUsers) => in_array($registeredUsers->role_id,[1,2,3]));
        Gate::define('delete-all', fn (RegisteredUsers $registeredUsers) => in_array($registeredUsers->role_id,[1,2,3]));
    }
}
