<?php

namespace Pataar\BrowserDetect;

use Illuminate\Cache\CacheManager;
use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * Registers the package as a service provider,
 * also injects the blade directives.
 */
class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register the custom blade directives.
     *
     * {@inheritDoc}
     */
    public function boot(): void
    {
        $this->registerDirectives();

        $source = realpath($raw = __DIR__.'/../config/browser-detect.php') ?: $raw;

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
            $method = 'is'.ucfirst($directive);
            Blade::if($directive, fn () => $this->resolveParser()->detect()->$method());
        }

        Blade::if(
            'browser',
            fn ($fn) => $this->resolveParser()->detect()->$fn()
        );
    }

    protected function resolveParser(): Parser
    {
        /** @var Parser $parser */
        $parser = $this->app->make('browser-detect');

        return $parser;
    }

    /**
     * Only binding can occur here!
     *
     * {@inheritdoc}
     */
    #[\Override]
    public function register(): void
    {
        $this->app->bind('browser-detect', function () {
            /** @var ConfigRepository $configRepo */
            $configRepo = $this->app->make('config');

            /** @var array<string, mixed> $config */
            $config = $configRepo['browser-detect'] ?? [];

            /** @var CacheManager $cache */
            $cache = $this->app->make('cache');

            /** @var Request $request */
            $request = $this->app->make('request');

            return new Parser($cache, $request, $config);
        });
    }
}
