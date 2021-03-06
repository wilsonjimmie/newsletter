<?php

namespace WilsonCreative\Newsletter;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

use WilsonCreative\Newsletter\Contracts\SubscriberRepositoryInterface;
use WilsonCreative\Newsletter\Contracts\MailinglistRepositoryInterface;
use WilsonCreative\Newsletter\Contracts\NewsletterRepositoryInterface;
use WilsonCreative\Newsletter\Repos\Subscriber\MailchimpSubscriber;
use WilsonCreative\Newsletter\Repos\Mailinglist\MailchimpMailinglist;
use WilsonCreative\Newsletter\Repos\Newsletter\MailchimpNewsletter;

class NewsletterServiceProvider extends ServiceProvider
{

    protected $defer = false;

    public function boot()
    {
        $this->loadViewsFrom(realpath(__DIR__ . '/../views'), 'newsletter');

        $this->setupRoutes($this->app->router);

        $this->publishes([
            __DIR__ . '/config/newsletter.php' => config_path('newsletter.php'),
        ], 'config');

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

        $getProvider = config('newsletter.provider');
        $provider = config('newsletter.providers.' . $getProvider);

        dd($provider);

        $this->app->bind(
            SubscriberRepositoryInterface::class,
            $provider['SubscriberRepo']
        );

        $this->app->bind(
            NewsletterRepositoryInterface::class,
            $provider['NewsletterRepo']
        );

        $this->app->bind(
            MailinglistRepositoryInterface::class,
            $provider['MailinglistRepo']
        );
    }
}