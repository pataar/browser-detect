<?php

namespace Pataar\BrowserDetect\Test;

use Pataar\BrowserDetect\Contracts\ParserInterface;
use Pataar\BrowserDetect\Facade;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\Exception;

/**
 * Class FacadeTest
 */
class FacadeTest extends TestCase
{
    /**
     * @covers \Pataar\BrowserDetect\Facade
     *
     * @throws \PHPUnit_Framework_AssertionFailedError
     * @throws AssertionFailedError
     * @throws \PHPUnit_Framework_Exception
     * @throws Exception
     */
    public function test_resolve()
    {
        $this->assertTrue(class_exists('Browser'));

        $expected = ParserInterface::class;
        $actual = Facade::getFacadeRoot();

        $this->assertInstanceOf($expected, $actual);
    }
}
