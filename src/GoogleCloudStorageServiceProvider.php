<?php

namespace IoDigital\GoogleCloudStorage;

use IoDigital\GoogleCloudStorage\Storage\GoogleClient;
use IoDigital\GoogleCloudStorage\Storage\GoogleCloudStorageHandler;

use Illuminate\Support\ServiceProvider;

class GoogleCloudStorageServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $config_file = __DIR__.'/config/config.php';

        $this->publishes([
            $config_file => config_path('google_cloud_storage.php'),
        ], 'config');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(GoogleCloudStorageHandler::class, function ($app) {
            return new GoogleCloudStorageHandler(new GoogleClient());
        });

        $this->app->alias('GoogleCloudStorageHandler',GoogleCloudStorageHandler::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['GoogleCloudStorageHandler'];
    }
}