<?php

namespace hisorange\BrowserDetect\Test;

use hisorange\BrowserDetect\Contracts\ParserInterface;
use hisorange\BrowserDetect\Contracts\ResultInterface;
use hisorange\BrowserDetect\Exceptions\BadMethodCallException;
use hisorange\BrowserDetect\Parser;
use Illuminate\Http\Request;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Exception;

/**
 * Class ParserTest
 *
 * @coversDefaultClass hisorange\BrowserDetect\Parser
 */
class ParserTest extends TestCase
{
    /**
     * @covers ::detect()
     * @covers ::makeHashKey()
     * @covers ::process()
     *
     * @throws \PHPUnit_Framework_Exception
     * @throws Exception
     */
    public function test_detect()
    {
        $parser = $this->getParser();
        $actual = $parser->detect();
        $expected = ResultInterface::class;

        $this->assertInstanceOf($expected, $actual);
    }

    /**
     * @covers ::config()
     */
    public function test_config_merge()
    {
        $i = new Parser(null, null, [
            'cache' => [
                'interval' => 42,
            ],
        ]);

        $this->assertSame($i->config()['cache']['interval'], 42);
        $this->assertSame($i->config()['cache']['prefix'], 'bd4_');
    }

    /**
     * @covers ::__construct()
     * @covers ::parse()
     */
    public function test_standalone_construct()
    {
        $this->assertInstanceOf(ResultInterface::class, (new Parser)->parse('test'));
    }

    /**
     * @covers ::__callStatic()
     * @covers ::getUserAgentString()
     */
    public function test_standalone_facade()
    {
        $this->assertSame(Parser::isMobile(), false);
    }

    /**
     * Check if the results are the same.
     */
    public function test_standalone_result()
    {
        $this->assertSame(Parser::toArray(), $this->getParser()->parse('')->toArray());
    }

    /**
     * @covers ::parse()
     */
    public function test_standalone_runtime_cache()
    {
        $this->assertSame(Parser::toArray(), Parser::toArray());
    }

    /**
     * @covers ::__construct()
     */
    protected function getParser(): ParserInterface
    {
        return $this->app->make('browser-detect');
    }

    /**
     * @param  string  $agent
     *
     * @covers ::parse()
     * @covers ::makeHashKey()
     * @covers ::process()
     *
     * @throws \PHPUnit_Framework_Exception
     * @throws Exception
     */
    #[DataProvider('provideAgents')]
    public function test_parse($agent)
    {
        $parser = $this->getParser();
        $actual = $parser->parse($agent);
        $expected = ResultInterface::class;

        $this->assertInstanceOf($expected, $actual);
    }

    /**
     * @return array
     */
    public static function provideAgents()
    {
        return [
            ['Unknown'],
            ['Mozilla/5.0 (Windows NT 6.1; WOW64; rv:40.0) Gecko/20100101 Firefox/40.1'],
            ['Mozilla/5.0 (Windows NT 6.3; rv:36.0) Gecko/20100101 Firefox/36.0'],
            ['Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36'],
            ['Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; AS; rv:11.0) like Gecko'],
            ['Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML like Gecko) Chrome/51.0.2704.79 Safari/537.36 Edge/14.14931'],
            ['Chrome (AppleWebKit/537.1; Chrome50.0; Windows NT 6.3) AppleWebKit/537.36 (KHTML like Gecko) Chrome/51.0.2704.79 Safari/537.36 Edge/14.14393'],
        ];
    }

    /**
     * @covers ::__call()
     *
     * @throws AssertionFailedError
     * @throws \PHPUnit_Framework_AssertionFailedError
     */
    public function test_call()
    {
        $this->assertNotEmpty($this->getParser()->userAgent());
    }

    /**
     * @covers ::__call()
     */
    public function test_call_exception()
    {
        $this->expectException(BadMethodCallException::class);
        $this->getParser()->BadMethod();
    }

    /**
     * @covers ::parse()
     */
    public function test_runtime_cache_returns_same_instance()
    {
        $parser = $this->getParser();
        $agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) TestCacheAgent';

        $first = $parser->parse($agent);
        $second = $parser->parse($agent);

        $this->assertSame($first, $second);
    }

    /**
     * @covers ::detect()
     */
    public function test_detect_truncates_long_user_agent()
    {
        $longAgent = str_repeat('A', 5000);
        $request = Request::create('/', 'GET', [], [], [], ['HTTP_USER_AGENT' => $longAgent]);
        $parser = new Parser(null, $request, [
            'security' => ['max-header-length' => 10],
        ]);

        $result = $parser->detect();

        $this->assertSame(10, strlen($result->userAgent()));
    }

    /**
     * Regression test for GitHub issue #16.
     * Ensures cached results don't produce __PHP_Incomplete_Class errors.
     *
     * @covers ::parse()
     */
    public function test_cache_returns_result_interface_not_incomplete_class()
    {
        $parser = $this->getParser();
        $agent = 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:149.0) Gecko/20100101 Firefox/149.0';

        // First call populates the cache.
        $first = $parser->parse($agent);
        $this->assertInstanceOf(ResultInterface::class, $first);

        // Create a new parser instance (no runtime cache) to force reading from the application cache.
        $freshParser = $this->getParser();
        $second = $freshParser->parse($agent);

        $this->assertInstanceOf(ResultInterface::class, $second);
        $this->assertSame($first->toArray(), $second->toArray());
    }
}
