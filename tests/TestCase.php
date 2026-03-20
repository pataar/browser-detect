<?php

namespace Pataar\BrowserDetect\Test;

use Illuminate\Foundation\Application;
use Pataar\BrowserDetect\Facade;
use Pataar\BrowserDetect\ServiceProvider;

/**
 * Base test case for the package tests.
 *
 * Class TestCase
 */
class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * Register the service.
     *
     * @param  Application  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    /**
     * Register the alias.
     *
     * @param  Application  $app
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'Browser' => Facade::class,
        ];
    }
}
