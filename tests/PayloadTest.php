<?php
namespace hisorange\BrowserDetect\Test;

use hisorange\BrowserDetect\Payload;

/**
 * Class PayloadTest
 * @package            hisorange\BrowserDetect\Test
 * @coversDefaultClass hisorange\BrowserDetect\Payload
 */
class PayloadTest extends TestCase
{
    /**
     * @covers ::__construct()
     * @covers ::getAgent()
     */
    public function testGetAgent()
    {
        $payload = new Payload('test');
        $this->assertSame('test', $payload->getAgent());
    }

    /**
     * @covers ::getValue()
     * @covers ::setValue()
     * @covers ::toArray()
     */
    public function testApi()
    {
        $payload = new Payload('test');
        $payload->setValue('a', 'b');

        $this->assertSame('b', $payload->getValue('a'));
        $this->assertSame([
            'a'         => 'b',
            'userAgent' => 'test',
        ], $payload->toArray());

        $this->assertNull($payload->getValue('non'));
    }

    /**
     * @covers ::setValue()
     */
    public function testSetValueIgnoresNull()
    {
        $payload = new Payload('test');
        $payload->setValue('key', 'value');
        $payload->setValue('key', null);

        $this->assertSame('value', $payload->getValue('key'));
    }

    /**
     * @covers ::setValue()
     */
    public function testSetValueNullDoesNotCreate()
    {
        $payload = new Payload('test');
        $payload->setValue('key', null);

        $this->assertNull($payload->getValue('key'));
        $this->assertArrayNotHasKey('key', $payload->toArray());
    }
}
