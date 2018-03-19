<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Smartwaiver\Smartwaiver;

class SmartwaiverServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Smartwaiver::class, function ($app) {
            return new Smartwaiver(config('services.smartwaiver.key'));
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [Smartwaiver::class];
    }
}
