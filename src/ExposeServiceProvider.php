<?php

namespace SCollins\LaravelExpose;

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
        $this->mergeConfigFrom(__DIR__ . '/../config/expose.php', 'expose');

        if (config('expose.cache', false) !== false) {
            $storage = new Storage($this->app['files'], config('expose.cache'));
            $storage->createStorage();
            $storage->garbageCollect();
        }

        $this->registerExpose();

        $this->app->alias('expose', Expose::class);
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

            $expose = new Expose($filters);

            if (config('expose.mail.enabled', false) === true) {
                $expose->setNotify($expose->makeNotify());
            }

            if (config('expose.cache', false) !== false) {
                $expose->setCache($expose->makeCache());
            }

            $expose->setLogger($expose->makeLogger());

            $app->refresh('request', $expose, 'setRequest');
            return $expose;
        });
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
