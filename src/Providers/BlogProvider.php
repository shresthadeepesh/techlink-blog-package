<?php


namespace Techlink\Blog\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Techlink\Blog\Console\Commands\BlogCommand;
use Techlink\Blog\Http\Middleware\ForgetSlugMiddleware;
use Techlink\Blog\View\Components\Alert;
use Techlink\Blog\View\Components\InputFile;
use Techlink\Blog\View\Components\InputSelect;
use Techlink\Blog\View\Components\InputSubmit;
use Techlink\Blog\View\Components\InputText;
use Techlink\Blog\View\Components\InputTextarea;
use Techlink\Blog\View\Components\Meta;
use Techlink\Blog\View\Components\ModelTable;
use Techlink\Blog\View\Components\PostBlock;

class BlogProvider extends ServiceProvider
{
    /**
     * Register services
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/blog.php', 'blog'
        );
    }

    /**
     * Bootstrap the services
     * @return void
     */
    public function boot()
    {
        if($this->app->runningInConsole()) {
            $this->registerPublishable();

            //registering the commands
            $this->commands([
                BlogCommand::class
            ]);
        }

        $this->registerResources();

        $this->bootViewComposers();

        $this->loadViewComponents();

        //register the middleware
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('slug', ForgetSlugMiddleware::class);
    }

    private function registerResources()
    {
        //loading the migrations
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        //load the views
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'blog');
//        $this->loadViewsFrom($this->app->resourcePath('views/techlink/blog'), 'blog');

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
          'middleware' => ['web', 'slug'],
          'as' => 'blog::',
          'prefix' => 'blog',
        ];
    }

    /**
     * Publishing the asset and other publishable files
     * @return void
     */
    private function registerPublishable()
    {
        //config
        $this->publishes([
            __DIR__ . '/../../config/blog.php' => config_path('blog.php'),
        ], 'config');

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

    private function loadViewComponents()
    {
        $this->loadViewComponentsAs('blog', [
            Alert::class,
            PostBlock::class,
            InputText::class,
            InputTextarea::class,
            InputSelect::class,
            InputSubmit::class,
            InputFile::class,
            Meta::class,
            ModelTable::class,
        ]);
    }
}