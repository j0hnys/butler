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
        \App::bind('App\Trident\Interfaces\Workflows\Logic\DefinitionInterface',function($app){
            return new \App\Trident\Workflows\Logic\Definition(
                new \App\Trident\Business\Logic\Definition, 
                new \App\Trident\Workflows\Repositories\DefinitionRepository($app)
            );
        });
        \App::bind('App\Trident\Interfaces\Workflows\Repositories\DefinitionRepositoryInterface',function($app){
            return new \App\Trident\Workflows\Repositories\DefinitionRepository($app);
        });
        \App::bind('App\Trident\Interfaces\Workflows\Logic\EntityInterface',function($app){
            return new \App\Trident\Workflows\Logic\Entity(
                new \App\Trident\Business\Logic\Entity, 
                new \App\Trident\Workflows\Repositories\EntityRepository($app)
            );
        });
        \App::bind('App\Trident\Interfaces\Workflows\Repositories\EntityRepositoryInterface',function($app){
            return new \App\Trident\Workflows\Repositories\EntityRepository($app);
        });
        \App::bind('App\Trident\Interfaces\Workflows\Logic\ProjectInterface',function($app){
            return new \App\Trident\Workflows\Logic\Project(
                new \App\Trident\Business\Logic\Project, 
                new \App\Trident\Workflows\Repositories\ProjectRepository($app)
            );
        });
        \App::bind('App\Trident\Interfaces\Workflows\Repositories\ProjectRepositoryInterface',function($app){
            return new \App\Trident\Workflows\Repositories\ProjectRepository($app);
        });
        \App::bind('App\Trident\Interfaces\Workflows\Logic\ViewInterface',function($app){
            return new \App\Trident\Workflows\Logic\View(
                new \App\Trident\Business\Logic\View, 
                new \App\Trident\Workflows\Repositories\ViewRepository($app)
            );
        });
        \App::bind('App\Trident\Interfaces\Workflows\Repositories\ViewRepositoryInterface',function($app){
            return new \App\Trident\Workflows\Repositories\ViewRepository($app);
        });
        \App::bind('App\Trident\Interfaces\Business\Logic\DefinitionInterface',function($app){
            return new \App\Trident\Business\Logic\Definition($app);
        });
        \App::bind('App\Trident\Interfaces\Business\Logic\EntityInterface',function($app){
            return new \App\Trident\Business\Logic\Entity($app);
        });
        \App::bind('App\Trident\Interfaces\Business\Logic\ProjectInterface',function($app){
            return new \App\Trident\Business\Logic\Project($app);
        });
        \App::bind('App\Trident\Interfaces\Business\Logic\ViewInterface',function($app){
            return new \App\Trident\Business\Logic\View($app);
        });
    }
}
