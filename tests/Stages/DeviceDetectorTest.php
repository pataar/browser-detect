<?php

namespace hisorange\BrowserDetect\Test\Stages;

use hisorange\BrowserDetect\Payload;
use hisorange\BrowserDetect\Test\TestCase;
use hisorange\BrowserDetect\Stages\DeviceDetector;
use PHPUnit\Framework\Attributes\DataProvider;

/**
 * Test the DeviceDetector stage.
 *
 * @package            hisorange\BrowserDetect\Test\Stages
 * @coversDefaultClass hisorange\BrowserDetect\Stages\DeviceDetector
 */
class DeviceDetectorTest extends TestCase
{
    /**
     * @covers ::__invoke()
     * @covers ::parseVersion()
     *
     * @param string $agent
     * @param array  $changes
     */
    #[DataProvider('provideAgents')]
    public function testInvoke($agent, $changes)
    {
        $stage  = new DeviceDetector;
        $result = new Payload($agent);

        $stage($result);

        foreach ($changes as $key => $expected) {
            $this->assertSame($expected, $result->getValue($key), 'Changes are not matched ' . print_r($changes, true) . ' with ' . $key . ' being ' . var_export($result->getValue($key), true));
        }
    }

    /**
     * Simple agents to test the crawler stage.
     *
     * @return array
     */
    public static function provideAgents()
    {
        return [

            [
                'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.108 Safari/537.360',
                [
                    'browserEngine'       => 'Blink',
                    'browserVersion'      => '63.0',
                    'browserVersionMajor' => 63,
                    'browserVersionMinor' => 0,
                    'browserVersionPatch' => null,
                ],
            ],
            [
                'Mozilla/5.0(iPad; U; CPU iPhone OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B314 Safari/531.21.',
                [
                    'isTablet' => true,
                ]
            ],
            [
                'NotGonaMatchMe',
                [
                    'isMobile'      => null,
                    'isTablet'      => null,
                    'isDesktop'     => null,
                    'browserEngine' => null,
                ],
            ],
            // Smartphone user agent
            [
                'Mozilla/5.0 (Linux; Android 10; SM-G973F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.149 Mobile Safari/537.36',
                [
                    'isMobile' => true,
                ],
            ],
        ];
    }

    /**
     * @covers ::__invoke()
     */
    public function testSkipsProcessingForBots()
    {
        $stage   = new DeviceDetector;
        $payload = new Payload('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.108 Safari/537.36');
        $payload->setValue('isBot', true);

        $stage($payload);

        // DeviceDetector should not set any browser/platform values when isBot is true
        $this->assertNull($payload->getValue('browserEngine'));
        $this->assertNull($payload->getValue('browserFamily'));
    }
}
