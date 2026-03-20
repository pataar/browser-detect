<?php

namespace hisorange\BrowserDetect\Test\Stages;

use hisorange\BrowserDetect\Payload;
use hisorange\BrowserDetect\Stages\CrawlerDetect;
use hisorange\BrowserDetect\Test\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

/**
 * Test the CrawlerDetect stage.
 *
 * @coversDefaultClass hisorange\BrowserDetect\Stages\CrawlerDetect
 */
class CrawlerDetectTest extends TestCase
{
    /**
     * @covers ::__invoke()
     *
     * @param  string  $agent
     * @param  bool  $expected
     */
    #[DataProvider('provideAgents')]
    public function test_invoke($agent, $expected)
    {
        $stage = new CrawlerDetect;
        $result = new Payload($agent);

        $stage($result);

        $this->assertSame($expected, $result->getValue('isBot'), sprintf('User agent "%s" failing the crawler test.', $agent));
    }

    /**
     * Simple agents to test the crawler stage.
     *
     * @return array
     */
    public static function provideAgents()
    {
        return [
            ['NotGoingToMatch', false],
            ['GoogleBot', true],
            ['Yahoo Crawler', true],
        ];
    }
}
