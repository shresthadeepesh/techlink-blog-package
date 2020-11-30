<?php


namespace Techlink\Blog\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class BlogProvider extends ServiceProvider
{
    /**
     * Register services
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap the services
     * @return void
     */
    public function boot()
    {
        if($this->app->runningInConsole()) {
            $this->registerPublishable();
        }

        $this->registerResources();
        $this->bootViewComposers();

        //using the bootstrap paginator
        Paginator::useBootstrap();
    }

    private function registerResources()
    {
        //loading the migrations
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        //load the views
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'blog');

        //registering the route
        $this->registerRoutes();
    }

    private function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function() {
           $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        });
    }

    /**
     * Configuring the route
     * @return array
     */
    private function routeConfiguration()
    {
        return [
          'middleware' => ['web'],
          'as' => 'techlink.blog.',
          'prefix' => 'blog',
//          'namespace' => 'Techlink\Blog\Http\Controllers',
        ];
    }

    /**
     * Publishing the asset and other publishable files
     * @return void
     */
    private function registerPublishable()
    {
        //publishing public files
        $this->publishes([
            __DIR__ . '/../../public/assets' => public_path('vendor/techlink/blog')
        ], 'public');

        //views
        $this->publishes([
            __DIR__ . '/../../resources/views' => base_path('resources/views/techlink/blog')
        ], 'views');

        //migrations
        $this->publishes([
            __DIR__ . '/../../database/migrations' => base_path('database/migrations')
        ], 'migrations');

        //factories
        $this->publishes([
            __DIR__ . '/../../database/factories' => base_path('database/factories')
        ], 'factories');
    }

    private function bootViewComposers()
    {
        //
    }
}