<?php

namespace hisorange\BrowserDetect;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * Registers the package as a service provider,
 * also injects the blade directives.
 *
 * @package hisorange\BrowserDetect
 */
class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register the custom blade directives.
     *
     * @inheritDoc
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerDirectives();

        $source = realpath($raw = __DIR__ . '/../config/browser-detect.php') ?: $raw;

        if ($this->app->runningInConsole()) {
            $this->publishes([
                $source => config_path('browser-detect.php'),
            ]);
        }

        $this->mergeConfigFrom($source, 'browser-detect');
    }

    /**
     * Register the blade directives.
     */
    protected function registerDirectives(): void
    {
        foreach (['desktop', 'tablet', 'mobile'] as $directive) {
            $method = 'is' . ucfirst($directive);
            Blade::if($directive, fn () => app()->make('browser-detect')->detect()->$method());
        }

        Blade::if(
            'browser',
            function ($fn) {
                return app()->make('browser-detect')->detect()->$fn();
            }
        );
    }

    /**
     * Only binding can occur here!
     *
     * @inheritdoc
     */
    public function register(): void
    {
        $this->app->bind('browser-detect', function ($app) {
            return new Parser($app->make('cache'), $app->make('request'), $app->make('config')['browser-detect'] ?? []);
        });
    }
}
