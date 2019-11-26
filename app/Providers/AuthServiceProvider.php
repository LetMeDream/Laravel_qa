<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\Response;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Gates help us authorize user to perform certain actions

        Gate::define('edit-question', function($user, $question){

            return $user->id === $question->user_id
                ? Response::allow()
                : Response::deny('You cannot edit this question.');;

        });

        Gate::define('delete-question', function($user, $question){

            return $user->id === $question->user_id;

        });

    }
}
