<?php

namespace WilsonCreative\Newsletter;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

class NewsletterServiceProvider extends ServiceProvider
{

    protected $defer = false;

    public function boot()
    {
        $this->loadViewsFrom(realpath(__DIR__ . '/../views'), 'newsletter');

        $this->setupRoutes($this->app->router);

        $this->publishes([
            __DIR__ . '/config/newsletter.php' => config_path('newsletter.php'),
        ]);
    }

    public function setupRoutes(Router $router)
    {
        $router->group(['namespace' => 'WilsonCreative\Newsletter\Http\Controllers'], function($router){
            require __DIR__ . '/Http/routes.php';
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerNewsletter();
        config([
            'config/newsletter.php'
        ]);
    }

    public function registerNewsletter()
    {
        $this->app->bind('newsletter', function($app) {
            return new Newsletter($app);
        });
    }
}