<?php

namespace hisorange\BrowserDetect\Test;

use hisorange\BrowserDetect\Contracts\ParserInterface;
use PHPUnit\Framework\Exception;

/**
 * Class ServiceProviderTest
 *
 * @coversDefaultClass hisorange\BrowserDetect\ServiceProvider
 */
class ServiceProviderTest extends TestCase
{
    /**
     * @covers ::register()
     * @covers ::registerDirectives()
     *
     * @throws \PHPUnit_Framework_Exception
     * @throws Exception
     */
    public function test_register()
    {
        $expected = ParserInterface::class;
        $actual = $this->app->make('browser-detect');

        $this->assertInstanceOf($expected, $actual);
    }
}
