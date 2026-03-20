<?php

namespace hisorange\BrowserDetect\Test;

use hisorange\BrowserDetect\Contracts\ResultInterface;
use hisorange\BrowserDetect\Result;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\Exception;

/**
 * Class ResultTest
 *
 * @coversDefaultClass hisorange\BrowserDetect\Result
 */
class ResultTest extends TestCase
{
    /**
     * @throws \PHPUnit_Framework_Exception
     * @throws Exception
     */
    public function test_interface_implementation()
    {
        $this->assertInstanceOf(ResultInterface::class, new Result([]));
    }

    /**
     * @covers ::__construct
     */
    public function test_construct()
    {
        $result = new Result(['userAgent' => 'test']);

        $this->assertSame('test', $result->userAgent());
    }

    /**
     * @covers ::toArray()
     */
    public function test_to_array()
    {
        $actual = $this->getEmptyResult()->toArray();
        $expected = [
            'userAgent' => 'Unknown',
            'isMobile' => false,
            'isTablet' => false,
            'isDesktop' => false,
            'isBot' => false,
            'isTV' => false,
            'isConsole' => false,
            'isWearable' => false,
            'isChrome' => false,
            'isFirefox' => false,
            'isOpera' => false,
            'isSafari' => false,
            'isEdge' => false,
            'isBrave' => false,
            'isVivaldi' => false,
            'isSamsungBrowser' => false,
            'isArc' => false,
            'isDuckDuckGo' => false,
            'isInApp' => false,
            'isIE' => false,
            'browserName' => 'Unknown',
            'browserFamily' => 'Unknown',
            'browserVersion' => '',
            'browserVersionMajor' => 0,
            'browserVersionMinor' => 0,
            'browserVersionPatch' => 0,
            'browserEngine' => 'Unknown',
            'platformName' => 'Unknown',
            'platformFamily' => 'Unknown',
            'platformVersion' => '',
            'platformVersionMajor' => 0,
            'platformVersionMinor' => 0,
            'platformVersionPatch' => 0,
            'isWindows' => false,
            'isLinux' => false,
            'isMac' => false,
            'isiOS' => false,
            'isChromeOS' => false,
            'isHarmonyOS' => false,
            'isAndroid' => false,
            'deviceFamily' => 'Unknown',
            'deviceModel' => '',
        ];

        $this->assertSame($expected, $actual);
    }

    /**
     * @return ResultInterface
     */
    protected function getEmptyResult()
    {
        return new Result([]);
    }

    /**
     * @covers ::__construct()
     * @covers ::userAgent()
     * @covers ::isMobile()
     * @covers ::isTablet()
     * @covers ::isDesktop()
     * @covers ::isBot()
     * @covers ::isChrome()
     * @covers ::isFirefox()
     * @covers ::isOpera()
     * @covers ::isSafari()
     * @covers ::isIE()
     * @covers ::isInApp()
     * @covers ::isEdge()
     * @covers ::browserName()
     * @covers ::browserFamily()
     * @covers ::browserVersion()
     * @covers ::browserVersionMajor()
     * @covers ::browserVersionMinor()
     * @covers ::browserVersionPatch()
     * @covers ::browserEngine()
     * @covers ::platformName()
     * @covers ::platformFamily()
     * @covers ::platformVersion()
     * @covers ::platformVersionMajor()
     * @covers ::platformVersionMinor()
     * @covers ::platformVersionPatch()
     * @covers ::isWindows()
     * @covers ::isLinux()
     * @covers ::isMac()
     * @covers ::isAndroid()
     * @covers ::deviceFamily()
     * @covers ::deviceModel()
     */
    public function test_user_agent()
    {
        $keys = $this->getKeys();
        $value = 'valueType';
        $result = new Result(array_fill_keys($keys, $value));

        $this->assertSame($value, $result->userAgent());
        $this->assertSame((bool) $value, $result->isMobile());
        $this->assertSame((bool) $value, $result->isTablet());
        $this->assertSame((bool) $value, $result->isDesktop());
        $this->assertSame((bool) $value, $result->isBot());
        $this->assertSame((bool) $value, $result->isTV());
        $this->assertSame((bool) $value, $result->isConsole());
        $this->assertSame((bool) $value, $result->isWearable());
        $this->assertSame((bool) $value, $result->isChrome());
        $this->assertSame((bool) $value, $result->isFirefox());
        $this->assertSame((bool) $value, $result->isOpera());
        $this->assertSame((bool) $value, $result->isSafari());
        $this->assertSame((bool) $value, $result->isIE());
        $this->assertSame((bool) $value, $result->isBrave());
        $this->assertSame((bool) $value, $result->isVivaldi());
        $this->assertSame((bool) $value, $result->isSamsungBrowser());
        $this->assertSame((bool) $value, $result->isArc());
        $this->assertSame((bool) $value, $result->isDuckDuckGo());
        $this->assertSame((bool) $value, $result->isInApp());
        $this->assertSame($value, $result->browserName());
        $this->assertSame($value, $result->browserFamily());
        $this->assertSame($value, $result->browserVersion());
        $this->assertSame((int) $value, $result->browserVersionMajor());
        $this->assertSame((int) $value, $result->browserVersionMinor());
        $this->assertSame((int) $value, $result->browserVersionPatch());
        $this->assertSame($value, $result->browserEngine());
        $this->assertSame($value, $result->platformName());
        $this->assertSame($value, $result->platformFamily());
        $this->assertSame($value, $result->platformVersion());
        $this->assertSame((int) $value, $result->platformVersionMajor());
        $this->assertSame((int) $value, $result->platformVersionMinor());
        $this->assertSame((int) $value, $result->platformVersionPatch());
        $this->assertSame((bool) $value, $result->isWindows());
        $this->assertSame((bool) $value, $result->isLinux());
        $this->assertSame((bool) $value, $result->isMac());
        $this->assertSame((bool) $value, $result->isiOS());
        $this->assertSame((bool) $value, $result->isChromeOS());
        $this->assertSame((bool) $value, $result->isHarmonyOS());
        $this->assertSame((bool) $value, $result->isAndroid());
        $this->assertSame($value, $result->deviceFamily());
        $this->assertSame($value, $result->deviceModel());
    }

    /**
     * @return array
     */
    protected function getKeys()
    {
        return [
            'userAgent',
            'isMobile',
            'isTablet',
            'isDesktop',
            'isBot',
            'isTV',
            'isConsole',
            'isWearable',
            'isChrome',
            'isFirefox',
            'isOpera',
            'isSafari',
            'isEdge',
            'isBrave',
            'isVivaldi',
            'isSamsungBrowser',
            'isArc',
            'isDuckDuckGo',
            'isInApp',
            'isIE',
            'browserName',
            'browserFamily',
            'browserVersion',
            'browserVersionMajor',
            'browserVersionMinor',
            'browserVersionPatch',
            'browserEngine',
            'platformName',
            'platformFamily',
            'platformVersion',
            'platformVersionMajor',
            'platformVersionMinor',
            'platformVersionPatch',
            'isWindows',
            'isLinux',
            'isMac',
            'isiOS',
            'isChromeOS',
            'isHarmonyOS',
            'isAndroid',
            'deviceFamily',
            'deviceModel',
        ];
    }

    /**
     * @covers ::isIEVersion()
     *
     * @throws AssertionFailedError
     * @throws \PHPUnit_Framework_AssertionFailedError
     */
    public function test_ie_version()
    {
        $result = new Result([
            'isIE' => true,
            'browserVersion' => 6,
        ]);

        $this->assertTrue($result->isIEVersion(6, '='));
        $this->assertTrue($result->isIEVersion(6, '<='));
        $this->assertFalse($result->isIEVersion(6, '>'));
        $this->assertFalse($result->isIEVersion(7, '>'));
    }

    public function test_json_output()
    {
        $parser = $this->app->make('browser-detect');
        $agent = 'Mozilla/5.0(iPad; U; CPU iPhone OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B314 Safari/531.21.';
        $result = $parser->parse($agent);
        // Encode and decode to get the keys.
        $keys = array_keys(json_decode(json_encode($result), true));

        $this->assertSame($keys, $this->getKeys());
    }

    public function test_chrome_family()
    {
        $parser = $this->app->make('browser-detect');
        $agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36';
        $result = $parser->parse($agent);

        $this->assertSame($result->isChrome(), true);
        $this->assertSame($result->isFirefox(), false);
        $this->assertSame($result->isOpera(), false);
        $this->assertSame($result->isSafari(), false);
        $this->assertSame($result->isIE(), false);
        $this->assertSame($result->isEdge(), false);
    }

    public function test_firefox_family()
    {
        $parser = $this->app->make('browser-detect');
        $agent = 'Mozilla/5.0 (X11; Linux i686; rv:64.0) Gecko/20100101 Firefox/64.0';
        $result = $parser->parse($agent);

        $this->assertSame($result->isChrome(), false);
        $this->assertSame($result->isFirefox(), true);
        $this->assertSame($result->isOpera(), false);
        $this->assertSame($result->isSafari(), false);
        $this->assertSame($result->isIE(), false);
        $this->assertSame($result->isEdge(), false);
    }

    public function test_opera_family()
    {
        $parser = $this->app->make('browser-detect');
        $agent = 'Opera/9.80 (Macintosh; Intel Mac OS X 10.14.1) Presto/2.12.388 Version/12.16';
        $result = $parser->parse($agent);

        $this->assertSame($result->isChrome(), false);
        $this->assertSame($result->isFirefox(), false);
        $this->assertSame($result->isOpera(), true);
        $this->assertSame($result->isSafari(), false);
        $this->assertSame($result->isIE(), false);
        $this->assertSame($result->isEdge(), false);
    }

    public function test_safari_family()
    {
        $parser = $this->app->make('browser-detect');
        $agent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_3) AppleWebKit/537.75.14 (KHTML, like Gecko) Version/7.0.3 Safari/7046A194A';
        $result = $parser->parse($agent);

        $this->assertSame($result->isChrome(), false);
        $this->assertSame($result->isFirefox(), false);
        $this->assertSame($result->isOpera(), false);
        $this->assertSame($result->isSafari(), true);
        $this->assertSame($result->isIE(), false);
        $this->assertSame($result->isEdge(), false);
    }

    public function test_ie_family()
    {
        $parser = $this->app->make('browser-detect');
        $agent = 'Mozilla/5.0 (compatible, MSIE 11, Windows NT 6.3; Trident/7.0; rv:11.0) like Gecko';
        $result = $parser->parse($agent);

        $this->assertSame($result->isChrome(), false);
        $this->assertSame($result->isFirefox(), false);
        $this->assertSame($result->isOpera(), false);
        $this->assertSame($result->isSafari(), false);
        $this->assertSame($result->isIE(), true);
        $this->assertSame($result->isEdge(), false);
    }

    public function test_edge_family()
    {
        $parser = $this->app->make('browser-detect');
        $agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML like Gecko) Chrome/51.0.2704.79 Safari/537.36 Edge/14.14931';
        $result = $parser->parse($agent);

        $this->assertSame($result->isChrome(), false);
        $this->assertSame($result->isFirefox(), false);
        $this->assertSame($result->isOpera(), false);
        $this->assertSame($result->isSafari(), false);
        $this->assertSame($result->isEdge(), true);
    }

    public function test_samsung_browser_family()
    {
        $parser = $this->app->make('browser-detect');
        $agent = 'Mozilla/5.0 (Linux; Android 13; SAMSUNG SM-S918B) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/21.0 Chrome/110.0.5481.154 Mobile Safari/537.36';
        $result = $parser->parse($agent);

        $this->assertTrue($result->isSamsungBrowser());
        $this->assertFalse($result->isChrome());
        $this->assertTrue($result->isMobile());
        $this->assertTrue($result->isAndroid());
    }

    public function test_brave_family()
    {
        $parser = $this->app->make('browser-detect');
        $agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Brave Chrome/116.0.0.0 Safari/537.36';
        $result = $parser->parse($agent);

        $this->assertTrue($result->isBrave());
        $this->assertFalse($result->isChrome());
        $this->assertTrue($result->isWindows());
        $this->assertTrue($result->isDesktop());
    }

    public function test_vivaldi_family()
    {
        $parser = $this->app->make('browser-detect');
        $agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36 Vivaldi/6.1.3035.84';
        $result = $parser->parse($agent);

        $this->assertTrue($result->isVivaldi());
        $this->assertFalse($result->isChrome());
        $this->assertTrue($result->isWindows());
    }

    public function test_duck_duck_go_family()
    {
        $parser = $this->app->make('browser-detect');
        $agent = 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.6 Mobile/15E148 DuckDuckGo/7 Safari/605.1.15';
        $result = $parser->parse($agent);

        $this->assertTrue($result->isDuckDuckGo());
        $this->assertFalse($result->isChrome());
        $this->assertFalse($result->isSafari());
        $this->assertTrue($result->isiOS());
        $this->assertTrue($result->isMobile());
    }

    public function test_windows()
    {
        $parser = $this->app->make('browser-detect');
        $agent = 'Mozilla/5.0 (Windows NT 5.1; rv:11.0) Gecko Firefox/11.0 (via ggpht.com GoogleImageProxy)';
        $result = $parser->parse($agent);

        $this->assertSame($result->platformFamily(), 'Windows');
        $this->assertSame($result->isWindows(), true);
    }

    public function test_ios()
    {
        $parser = $this->app->make('browser-detect');
        $agent = 'Mozilla/5.0 (iPhone; CPU iPhone OS 12_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148';
        $result = $parser->parse($agent);

        $this->assertSame('iOS', $result->platformFamily());
        $this->assertTrue($result->isiOS());
        $this->assertFalse($result->isMac());
    }

    public function test_mac()
    {
        $parser = $this->app->make('browser-detect');
        $agent = 'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_6; en-en) AppleWebKit/533.19.4 (KHTML, like Gecko) Version/5.0.3 Safari/533.19.4';
        $result = $parser->parse($agent);

        $this->assertSame($result->platformFamily(), 'Mac');
        $this->assertSame($result->isMac(), true);
    }

    public function test_android()
    {
        $parser = $this->app->make('browser-detect');
        $agent = 'Mozilla/5.0 (Linux; U; Android 2.2) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1';
        $result = $parser->parse($agent);

        $this->assertSame($result->platformFamily(), 'Android');
        $this->assertSame($result->isAndroid(), true);
    }

    public function test_linux()
    {
        $parser = $this->app->make('browser-detect');
        $agent = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.157 Safari/537.36';
        $result = $parser->parse($agent);

        $this->assertSame($result->platformFamily(), 'GNU/Linux');
        $this->assertSame($result->isLinux(), true);
    }

    public function test_device_type_mobile()
    {
        $result = new Result(['isMobile' => true]);
        $this->assertSame('Mobile', $result->deviceType());
    }

    public function test_device_type_tablet()
    {
        $result = new Result(['isTablet' => true]);
        $this->assertSame('Tablet', $result->deviceType());
    }

    public function test_device_type_bot()
    {
        $result = new Result(['isBot' => true]);
        $this->assertSame('Bot', $result->deviceType());
    }

    public function test_device_type_desktop()
    {
        $result = new Result(['isDesktop' => true]);
        $this->assertSame('Desktop', $result->deviceType());
    }

    public function test_device_type_unknown()
    {
        $result = new Result([]);
        $this->assertSame('Unknown', $result->deviceType());
    }

    public function test_device_type_priority()
    {
        // Mobile takes priority over Desktop
        $result = new Result(['isMobile' => true, 'isDesktop' => true]);
        $this->assertSame('Mobile', $result->deviceType());
    }

    public function test_is_ie_version_when_not_ie()
    {
        $result = new Result([
            'isIE' => false,
            'browserVersion' => 6,
        ]);

        $this->assertFalse($result->isIEVersion(6, '='));
    }

    public function test_device_type_tv()
    {
        $result = new Result(['isTV' => true]);
        $this->assertSame('TV', $result->deviceType());
    }

    public function test_device_type_console()
    {
        $result = new Result(['isConsole' => true]);
        $this->assertSame('Console', $result->deviceType());
    }

    public function test_device_type_wearable()
    {
        $result = new Result(['isWearable' => true]);
        $this->assertSame('Wearable', $result->deviceType());
    }

    public function test_device_type_tv_priority()
    {
        // TV takes priority over Desktop (TV devices also get isDesktop from BrowserDetect stage)
        $result = new Result(['isTV' => true, 'isDesktop' => true]);
        $this->assertSame('TV', $result->deviceType());
    }

    public function test_i_pad_returns_ios_not_mac()
    {
        $parser = $this->app->make('browser-detect');
        $agent = 'Mozilla/5.0 (iPad; CPU OS 16_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.6 Mobile/15E148 Safari/604.1';
        $result = $parser->parse($agent);

        $this->assertSame('iPadOS', $result->platformFamily());
        $this->assertTrue($result->isiOS());
        $this->assertFalse($result->isMac());
        $this->assertTrue($result->isTablet());
    }

    public function test_chrome_os()
    {
        $parser = $this->app->make('browser-detect');
        $agent = 'Mozilla/5.0 (X11; CrOS x86_64 14541.0.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36';
        $result = $parser->parse($agent);

        $this->assertSame('Chrome OS', $result->platformFamily());
        $this->assertTrue($result->isChromeOS());
        $this->assertFalse($result->isLinux());
    }

    public function test_harmony_os()
    {
        $parser = $this->app->make('browser-detect');
        $agent = 'Mozilla/5.0 (Linux; Android 10; HarmonyOS; ALN-AL10; HMSCore 6.11.0.302) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.88 HuaweiBrowser/13.0.4.302 Mobile Safari/537.36';
        $result = $parser->parse($agent);

        $this->assertTrue($result->isHarmonyOS());
        $this->assertFalse($result->isAndroid());
        $this->assertFalse($result->isLinux());
        $this->assertTrue($result->isMobile());
    }

    public function test_smart_tv_integration()
    {
        $parser = $this->app->make('browser-detect');
        $agent = 'Mozilla/5.0 (SMART-TV; LINUX; Tizen 5.0) AppleWebKit/537.36 (KHTML, like Gecko) Version/5.0 TV Safari/537.36';
        $result = $parser->parse($agent);

        $this->assertTrue($result->isTV());
        $this->assertSame('TV', $result->deviceType());
    }

    public function test_game_console_integration()
    {
        $parser = $this->app->make('browser-detect');
        $agent = 'Mozilla/5.0 (PlayStation 5 5.02) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0 Safari/605.1.15';
        $result = $parser->parse($agent);

        $this->assertTrue($result->isConsole());
        $this->assertSame('Console', $result->deviceType());
    }

    public function test_wearable_integration()
    {
        $parser = $this->app->make('browser-detect');
        $agent = 'atc/1.0 watchOS/9.0.0 model/Watch6,2 hwp/t8301 build/20R5332g';
        $result = $parser->parse($agent);

        $this->assertTrue($result->isWearable());
        $this->assertSame('Wearable', $result->deviceType());
    }

    public function test_facebook_in_app_integration()
    {
        $parser = $this->app->make('browser-detect');
        $agent = 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/20A362 [FBAN/FBIOS;FBDV/iPhone14,2;FBMD/iPhone]';
        $result = $parser->parse($agent);

        $this->assertTrue($result->isInApp());
        $this->assertTrue($result->isiOS());
        $this->assertTrue($result->isMobile());
    }
}
