<?php

namespace Pataar\BrowserDetect\Test\Stages;

use Pataar\BrowserDetect\Payload;
use Pataar\BrowserDetect\Stages\DeviceDetector;
use Pataar\BrowserDetect\Test\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

/**
 * Test the DeviceDetector stage.
 *
 * @coversDefaultClass Pataar\BrowserDetect\Stages\DeviceDetector
 */
class DeviceDetectorTest extends TestCase
{
    /**
     * @covers ::__invoke()
     * @covers ::parseVersion()
     *
     * @param  string  $agent
     * @param  array  $changes
     */
    #[DataProvider('provideAgents')]
    public function test_invoke($agent, $changes)
    {
        $stage = new DeviceDetector;
        $result = new Payload($agent);

        $stage($result);

        foreach ($changes as $key => $expected) {
            $this->assertSame($expected, $result->getValue($key), 'Changes are not matched '.print_r($changes, true).' with '.$key.' being '.var_export($result->getValue($key), true));
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
                    'browserEngine' => 'Blink',
                    'browserVersionMajor' => 63,
                    'browserVersionMinor' => 0,
                    'browserVersionPatch' => null,
                ],
            ],
            [
                'Mozilla/5.0(iPad; U; CPU iPhone OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B314 Safari/531.21.',
                [
                    'isTablet' => true,
                ],
            ],
            [
                'NotGonaMatchMe',
                [
                    'isMobile' => null,
                    'isTablet' => null,
                    'isDesktop' => null,
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
    public function test_skips_device_classification_for_bots()
    {
        $stage = new DeviceDetector;
        $payload = new Payload('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.108 Safari/537.36');
        $payload->setValue('isBot', true);

        $stage($payload);

        // Browser/platform info should still be extracted for bots
        $this->assertSame('Blink', $payload->getValue('browserEngine'));
        $this->assertSame('Chrome', $payload->getValue('browserFamily'));

        // Device-type flags should not be set for bots
        $this->assertNull($payload->getValue('isMobile'));
        $this->assertNull($payload->getValue('isTablet'));
        $this->assertNull($payload->getValue('isDesktop'));
    }
}
