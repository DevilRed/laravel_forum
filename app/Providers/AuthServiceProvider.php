<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Thread;
use App\Policies\ThreadPolicy;
use Illuminate\Support\Facades\Gate;
// use Illuminate\Auth\Access\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Thread::class => ThreadPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // bypass any policies for admin case
        Gate::before(function ($user) {
            if ($user->name == 'dos') return true;
        });
    }
}
