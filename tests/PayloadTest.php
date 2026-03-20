<?php

namespace hisorange\BrowserDetect\Test;

use hisorange\BrowserDetect\Payload;

/**
 * Class PayloadTest
 *
 * @coversDefaultClass hisorange\BrowserDetect\Payload
 */
class PayloadTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @covers ::getAgent()
     */
    public function test_get_agent()
    {
        $payload = new Payload('test');
        $this->assertSame('test', $payload->getAgent());
    }

    /**
     * @covers ::getValue()
     * @covers ::setValue()
     * @covers ::toArray()
     */
    public function test_api()
    {
        $payload = new Payload('test');
        $payload->setValue('a', 'b');

        $this->assertSame('b', $payload->getValue('a'));
        $this->assertSame([
            'a' => 'b',
            'userAgent' => 'test',
        ], $payload->toArray());

        $this->assertNull($payload->getValue('non'));
    }

    /**
     * @covers ::setValue()
     */
    public function test_set_value_ignores_null()
    {
        $payload = new Payload('test');
        $payload->setValue('key', 'value');
        $payload->setValue('key', null);

        $this->assertSame('value', $payload->getValue('key'));
    }

    /**
     * @covers ::setValue()
     */
    public function test_set_value_null_does_not_create()
    {
        $payload = new Payload('test');
        $payload->setValue('key', null);

        $this->assertNull($payload->getValue('key'));
        $this->assertArrayNotHasKey('key', $payload->toArray());
    }
}
