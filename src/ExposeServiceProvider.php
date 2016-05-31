<?php

namespace SCollins\LaravelExpose;

use Log;
use Expose\FilterCollection;
use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;

class ExposeServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerExpose();

        $this->mergeConfigFrom(__DIR__ . '../config/expose.php', 'expose');
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '../config/expose.php' => config_path('expose.php'),
        ]);
    }

    /**
     * Register the expose class.
     *
     * @return void
     */
    protected function registerExpose()
    {
        $this->app->singleton('expose', function (Container $app) {
            $filters = new FilterCollection();
            $filters->load();
            $logger = Log::getMonolog();
            $expose = new Expose($filters, $logger);
            $app->refresh('request', $expose, 'setRequest');
            return $expose;
        });
        $this->app->alias('expose', Expose::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides()
    {
        return [
            'expose',
        ];
    }
}
