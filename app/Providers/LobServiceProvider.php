<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class LobServiceProvider extends ServiceProvider
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
        $this->app->singleton(\Lob\Lob::class, function ($app) {
            return new \Lob\Lob(config('services.lob.key'));
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [\Lob\Lob::class];
    }
}
