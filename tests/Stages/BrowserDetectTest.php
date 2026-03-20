<?php

namespace Pataar\BrowserDetect\Test\Stages;

use Pataar\BrowserDetect\Contracts\ResultInterface;
use Pataar\BrowserDetect\Payload;
use Pataar\BrowserDetect\Result;
use Pataar\BrowserDetect\Stages\BrowserDetect;
use Pataar\BrowserDetect\Test\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

/**
 * Test the BrowserDetect stage.
 *
 * @coversDefaultClass Pataar\BrowserDetect\Stages\BrowserDetect
 */
class BrowserDetectTest extends TestCase
{
    /**
     * @covers ::__invoke()
     *
     * @param  array  $scenario
     * @param  array  $expectations
     *
     * @throws Exception
     * @throws \PHPUnit_Framework_Exception
     */
    #[DataProvider('provideScenarios')]
    public function test_invoke($scenario, $expectations)
    {
        $stage = new BrowserDetect;
        $payload = new Payload('Unknown');

        foreach ($scenario as $k => $v) {
            $payload->setValue($k, $v);
        }

        $payload = $stage($payload);
        $result = new Result($payload->toArray());

        $this->assertInstanceOf(ResultInterface::class, $result);

        foreach ($expectations as $key => $expected) {
            $this->assertSame($expected, $result->$key(), sprintf('Key %s not matching when %s', $key, print_r($scenario, true)));
        }
    }

    /**
     * Check if the Prerender agents are recognized as desktop bot
     *
     * @return void
     */
    public function test_prerender_bot()
    {
        $stage = new BrowserDetect;
        $payload = new Payload('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/W.X.Y.Z Safari/537.36 Prerender (+https://github.com/prerender/prerender)');

        $payload = $stage($payload);
        $result = new Result($payload->toArray());

        $this->assertTrue($result->isBot());
        $this->assertFalse($result->isMobile());
        $this->assertFalse($result->isTablet());
        $this->assertTrue($result->isDesktop());
    }

    /**
     * Check if the Prerender agents are recognized as desktop bot
     *
     * @return void
     */
    public function test_prerender_mobile_bot()
    {
        $stage = new BrowserDetect;
        $payload = new Payload('Mozilla/5.0 (Linux; Android 11; Pixel 5) AppleWebKit/537.36 (KHTML, like Gecko)'.
            'Chrome/W.X.Y.Z Mobile Safari/537.36 Prerender (+https://github.com/prerender/prerender)');

        $payload = $stage($payload);
        $result = new Result($payload->toArray());

        $this->assertTrue($result->isBot());
        $this->assertTrue($result->isMobile());
        $this->assertFalse($result->isTablet());
        $this->assertFalse($result->isDesktop());
    }

    /**
     * Check for WebView inApp browsers.
     *
     * @return void
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function test_in_app_web_view()
    {
        $stage = new BrowserDetect;
        $payload = new Payload('WebView');

        $payload = $stage($payload);
        $result = new Result($payload->toArray());

        $this->assertTrue($result->isInApp());

        $stage = new BrowserDetect;
        $payload = new Payload('Mozilla/5.0 (iPhone; CPU iPhone OS 10_0_1 like Mac OS X) '.
            'AppleWebKit/602.1.32 (KHTML, like Gecko) Mobile/14A403 Twitter for iPhone');

        $payload = $stage($payload);
        $result = new Result($payload->toArray());

        $this->assertTrue($result->isInApp());

        $stage = new BrowserDetect;
        $payload = new Payload('Mozilla/5.0 (iPhone; CPU iPhone OS 10_1_1 like Mac OS X) '.
            'AppleWebKit/602.2.14 (KHTML, like Gecko) Mobile/14B100 MicroMessenger/6.3.30 NetType/WIFI Language/en');

        $payload = $stage($payload);
        $result = new Result($payload->toArray());

        $this->assertTrue($result->isInApp());
    }

    /**
     * Check for Apple inApp browsers.
     *
     * @return void
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function test_in_app_apple()
    {
        $stage = new BrowserDetect;
        $payload = new Payload('Mozilla/5.0 (iPhone; CPU iPhone OS 9_3_5 like Mac OS X) '.
            'AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13G36');
        $payload = $stage($payload);
        $result = new Result($payload->toArray());
        $this->assertTrue($result->isInApp());
    }

    /**
     * Check for Andorid inApp browsers.
     *
     * @return void
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function test_in_app_android()
    {
        $stage = new BrowserDetect;
        $payload = new Payload('Mozilla/5.0 (Linux; Android 5.1.1; Nexus 5 Build/LMY48B; wv) '.
            'AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/43.0.2357.65 Mobile Safari/537.36');
        $payload = $stage($payload);
        $result = new Result($payload->toArray());
        $this->assertTrue($result->isInApp());
    }

    public function test_not_in_app()
    {
        $stage = new BrowserDetect;
        $payload = new Payload('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.149 Safari/537.36');

        $payload = $stage($payload);
        $result = new Result($payload->toArray());

        $this->assertFalse($result->isInApp());
    }

    public function test_null_browser_family_does_not_set_any_browser_flag()
    {
        $stage = new BrowserDetect;
        $payload = new Payload('Unknown');

        $payload = $stage($payload);
        $result = new Result($payload->toArray());

        $this->assertFalse($result->isChrome());
        $this->assertFalse($result->isFirefox());
        $this->assertFalse($result->isOpera());
        $this->assertFalse($result->isSafari());
        $this->assertFalse($result->isIE());
        $this->assertFalse($result->isEdge());
        $this->assertFalse($result->isBrave());
        $this->assertFalse($result->isVivaldi());
        $this->assertFalse($result->isSamsungBrowser());
        $this->assertFalse($result->isArc());
        $this->assertFalse($result->isDuckDuckGo());
    }

    public function test_null_platform_family_does_not_set_any_platform_flag()
    {
        $stage = new BrowserDetect;
        $payload = new Payload('Unknown');

        $payload = $stage($payload);
        $result = new Result($payload->toArray());

        $this->assertFalse($result->isWindows());
        $this->assertFalse($result->isLinux());
        $this->assertFalse($result->isMac());
        $this->assertFalse($result->isiOS());
        $this->assertFalse($result->isChromeOS());
        $this->assertFalse($result->isHarmonyOS());
        $this->assertFalse($result->isAndroid());
    }

    /**
     * Test browser family detection with exclusivity: setting one browser flag
     * must not set any other browser flag.
     */
    #[DataProvider('provideBrowserFamilyScenarios')]
    public function test_browser_family_detection(string $browserFamily, string $expectedMethod): void
    {
        $allBrowserMethods = [
            'isArc', 'isBrave', 'isChrome', 'isDuckDuckGo', 'isEdge',
            'isFirefox', 'isIE', 'isOpera', 'isSafari', 'isSamsungBrowser', 'isVivaldi',
        ];

        $stage = new BrowserDetect;
        $payload = new Payload('Unknown');
        $payload->setValue('browserFamily', $browserFamily);

        $payload = $stage($payload);
        $result = new Result($payload->toArray());

        $this->assertTrue($result->$expectedMethod(), "$expectedMethod should be true for browserFamily '$browserFamily'");

        foreach ($allBrowserMethods as $method) {
            if ($method !== $expectedMethod) {
                $this->assertFalse($result->$method(), "$method should be false when $expectedMethod is true");
            }
        }
    }

    public static function provideBrowserFamilyScenarios(): array
    {
        return [
            'Arc' => ['Arc', 'isArc'],
            'Brave' => ['Brave', 'isBrave'],
            'DuckDuckGo' => ['DuckDuckGo Privacy Browser', 'isDuckDuckGo'],
            'Samsung Browser' => ['Samsung Browser', 'isSamsungBrowser'],
            'Vivaldi' => ['Vivaldi', 'isVivaldi'],
        ];
    }

    /**
     * Test platform family detection with exclusivity: setting one platform flag
     * must not set any other platform flag.
     */
    #[DataProvider('providePlatformFamilyScenarios')]
    public function test_platform_family_detection(string $platformFamily, string $expectedMethod): void
    {
        $allPlatformMethods = [
            'isAndroid', 'isChromeOS', 'isHarmonyOS', 'isiOS', 'isLinux', 'isMac', 'isWindows',
        ];

        $stage = new BrowserDetect;
        $payload = new Payload('Unknown');
        $payload->setValue('platformFamily', $platformFamily);

        $payload = $stage($payload);
        $result = new Result($payload->toArray());

        $this->assertTrue($result->$expectedMethod(), "$expectedMethod should be true for platformFamily '$platformFamily'");

        foreach ($allPlatformMethods as $method) {
            if ($method !== $expectedMethod) {
                $this->assertFalse($result->$method(), "$method should be false when $expectedMethod is true");
            }
        }
    }

    public static function providePlatformFamilyScenarios(): array
    {
        return [
            'Chrome OS' => ['Chrome OS', 'isChromeOS'],
            'HarmonyOS' => ['HarmonyOS', 'isHarmonyOS'],
            'iOS' => ['iOS', 'isiOS'],
            'iPadOS' => ['iPadOS', 'isiOS'],
            'Mac' => ['Mac', 'isMac'],
        ];
    }

    #[DataProvider('provideInAppScenarios')]
    public function test_in_app_detection(string $agent): void
    {
        $stage = new BrowserDetect;
        $payload = new Payload($agent);

        $payload = $stage($payload);
        $result = new Result($payload->toArray());

        $this->assertTrue($result->isInApp(), "isInApp should be true for agent: $agent");
    }

    public static function provideInAppScenarios(): array
    {
        return [
            'Facebook FBAN' => ['Mozilla/5.0 (iPhone; CPU iPhone OS 16_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/20A362 [FBAN/FBIOS;FBDV/iPhone14,2;FBMD/iPhone]'],
            'Facebook FBAV' => ['Mozilla/5.0 (Linux; Android 13; SM-S918B Build/TP1A.220624.014) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/112.0.5615.135 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/413.0.0.30.104]'],
            'Instagram' => ['Mozilla/5.0 (iPhone; CPU iPhone OS 16_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/20A362 Instagram 296.0.0.13.109'],
            'TikTok BytedanceWebview' => ['Mozilla/5.0 (Linux; Android 12; SM-G991B Build/SP1A.210812.016) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/107.0.5304.141 Mobile Safari/537.36 BytedanceWebview/d8a21c6'],
            'TikTok musical_ly' => ['Mozilla/5.0 (iPhone; CPU iPhone OS 16_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/20A362 musical_ly_27.7.0 JsSdk/2.0'],
            'Snapchat' => ['Mozilla/5.0 (iPhone; CPU iPhone OS 16_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.6 Mobile/15E148 Snapchat/12.45.0.38'],
            'LinkedIn' => ['Mozilla/5.0 (iPhone; CPU iPhone OS 16_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/20A362 LinkedInApp'],
            'Telegram' => ['Mozilla/5.0 (iPhone; CPU iPhone OS 16_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/20A362 Telegram/9.6.1'],
            'TelegramBot' => ['TelegramBot (like TwitterBot)'],
            'Line' => ['Mozilla/5.0 (iPhone; CPU iPhone OS 16_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/20A362 Safari/604.1 Line/13.6.1'],
            'Pinterest' => ['Mozilla/5.0 (iPhone; CPU iPhone OS 16_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/20A362 Pinterest/10.35'],
        ];
    }

    /**
     * Possible device scenarios.
     *
     * @return array
     */
    public static function provideScenarios()
    {
        return [
            [
                [
                    'isDesktop' => true,
                    'isTablet' => true,
                    'isMobile' => true,
                ],
                [
                    'isDesktop' => false,
                    'isTablet' => true,
                    'isMobile' => false,
                ],
            ],
            [
                [
                    'isDesktop' => true,
                    'isTablet' => true,
                    'isMobile' => false,
                ],
                [
                    'isDesktop' => false,
                    'isTablet' => true,
                    'isMobile' => false,
                ],
            ],
            [
                [
                    'isDesktop' => true,
                    'isTablet' => false,
                    'isMobile' => false,
                ],
                [
                    'isDesktop' => true,
                    'isTablet' => false,
                    'isMobile' => false,
                ],
            ],
            [
                [
                    'isDesktop' => false,
                    'isTablet' => false,
                    'isMobile' => true,
                ],
                [
                    'isDesktop' => false,
                    'isTablet' => false,
                    'isMobile' => true,
                ],
            ],
            [
                [
                    'isDesktop' => true,
                    'isTablet' => false,
                    'isMobile' => true,
                ],
                [
                    'isDesktop' => false,
                    'isTablet' => false,
                    'isMobile' => true,
                ],
            ],
            [
                [
                    'isDesktop' => false,
                    'isTablet' => true,
                    'isMobile' => true,
                ],
                [
                    'isDesktop' => false,
                    'isTablet' => true,
                    'isMobile' => false,
                ],
            ],
            [
                [
                    'isDesktop' => true,
                    'isTablet' => false,
                    'isMobile' => false,
                ],
                [
                    'isDesktop' => true,
                    'isTablet' => false,
                    'isMobile' => false,
                ],
            ],
        ];
    }
}
