<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class TridentAuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Trident\Workflows\Repositories\DefinitionRepository' => 'App\Policies\Trident\DefinitionPolicy',
        'App\Trident\Workflows\Repositories\EntityRepository' => 'App\Policies\Trident\EntityPolicy',
        'App\Trident\Workflows\Repositories\ProjectRepository' => 'App\Policies\Trident\ProjectPolicy',
        'App\Trident\Workflows\Repositories\TestRepository' => 'App\Policies\Trident\TestPolicy',
        'App\Trident\Workflows\Repositories\ViewRepository' => 'App\Policies\Trident\ViewPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
