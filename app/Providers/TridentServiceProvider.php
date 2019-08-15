<?php

namespace App\Providers;

use Illuminate\Container\Container as App;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Finder\Finder;

class TridentServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //EDW THA PREPEI NA KANW GENERATED TOYS PROVIDERS MOY!!!
        \App::bind('App\Trident\Interfaces\Workflows\Logic\ProjectInterface',function($app){
            return new \App\Trident\Workflows\Logic\Project(
                new \App\Trident\Business\Logic\Project, 
                new \App\Trident\Workflows\Repositories\ProjectRepository($app)
            );
        });
        \App::bind('App\Trident\Interfaces\Workflows\Repositories\ProjectRepositoryInterface',function($app){
            return new \App\Trident\Workflows\Repositories\ProjectRepository($app);
        });
        \App::bind('App\Trident\Interfaces\Business\Logic\ProjectInterface',function($app){
            return new \App\Trident\Business\Logic\Project($app);
        });
    }
}
