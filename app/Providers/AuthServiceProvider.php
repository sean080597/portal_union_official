<?php

namespace App\Providers;

use Laravel\Passport\Passport;
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
        $this->registerPolicies();

        Passport::routes();

        Gate::define('isShit', function(){
            return true;
        });

        Gate::define('isAdmin', function($user){
            return $user->role_id === 'adm';
        });

        Gate::define('isAccSchool', function($user){
            return $user->role_id === 'sch';
        });

        Gate::define('isAccFaculty', function($user){
            return $user->role_id === 'fac';
        });

        Gate::define('isAccStudent', function($user){
            return $user->role_id === 'stu';
        });
    }
}
