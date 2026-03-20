<?php

namespace hisorange\BrowserDetect;

use hisorange\BrowserDetect\Contracts\StageInterface;
use Illuminate\Http\Request;
use Illuminate\Cache\CacheManager;
use hisorange\BrowserDetect\Contracts\ParserInterface;
use hisorange\BrowserDetect\Contracts\ResultInterface;
use hisorange\BrowserDetect\Exceptions\BadMethodCallException;

/**
 * Manages the parsing mechanism.
 *
 * @package hisorange\BrowserDetect
 */
final class Parser implements ParserInterface
{
    /**
     * @var CacheManager|null
     */
    protected $cache;

    /**
     * @var Request|null
     */
    protected $request;

    /**
     * Runtime cache to reduce the parse calls.
     *
     * @var array<string, ResultInterface>
     */
    protected $runtime;

    /**
     * Parsing configurations.
     *
     * @var array<string, mixed>
     */
    protected $config;

    /**
     * Reusable pipeline stages.
     *
     * @var StageInterface[]
     */
    protected $pipeline;

    /**
     * Singleton used in standalone mode.
     *
     * @var self|null
     */
    protected static $instance;

    /**
     * Parser constructor.
     *
     * @param CacheManager|null $cache
     * @param Request|null      $request
     * @param array<string, mixed> $config
     */
    public function __construct(?CacheManager $cache = null, ?Request $request = null, array $config = [])
    {
        if ($cache !== null) {
            $this->cache   = $cache;
        }

        if ($request !== null) {
            $this->request = $request;
        }

        /** @var array<string, mixed> $defaults */
        $defaults = require __DIR__ . '/../config/browser-detect.php';

        /** @var array<string, mixed> $merged */
        $merged = array_replace_recursive($defaults, $config);
        $this->config = $merged;

        $this->runtime = [];

        $this->pipeline = [
            new Stages\CrawlerDetect(),
            new Stages\DeviceDetector(),
            new Stages\BrowserDetect(),
        ];
    }

    /**
     * Read the applied final config.
     *
     * @return array<string, mixed>
     */
    public function config(): array
    {
        return $this->config;
    }

    /**
     * Reflect calls to the result object.
     *
     * @throws \hisorange\BrowserDetect\Exceptions\BadMethodCallException
     *
     * @param string $method
     * @param array<int, mixed>  $params
     *
     * @return mixed
     */
    public function __call(string $method, array $params)
    {
        $result = $this->detect();

        // Reflect a method.
        if (method_exists($result, $method)) {
            /* @phpstan-ignore-next-line */
            return call_user_func_array([$result, $method], $params);
        }

        throw new BadMethodCallException(
            sprintf('%s method does not exists on the %s object.', $method, ResultInterface::class)
        );
    }

    /**
     * Acts as a facade, but proxies all the call to a singleton.
     *
     * @param string $method
     * @param array<int, mixed> $params
     *
     * @return mixed
     */
    public static function __callStatic(string $method, array $params)
    {
        if (!static::$instance) {
            static::$instance = new static();
        }

        /* @phpstan-ignore-next-line */
        return call_user_func_array([static::$instance, $method], $params);
    }

    /**
     * @inheritdoc
     */
    public function detect(): ResultInterface
    {
        // Cuts the agent string at 2048 byte, anything longer will be a DoS attack.
        $userAgentString = substr(
            $this->getUserAgentString(),
            0,
            $this->securityConfig()['max-header-length']
        );

        return $this->parse($userAgentString);
    }

    /**
     * Wrapper around the request accessor, in standalone mode
     * the fn will use the $_SERVER global.
     *
     * @return string
     */
    protected function getUserAgentString(): string
    {
        if ($this->request !== null) {
            return $this->request->userAgent() ?? '';
        } else {
            return is_string($_SERVER['HTTP_USER_AGENT'] ?? null) ? $_SERVER['HTTP_USER_AGENT'] : '';
        }
    }

    /**
     * @inheritdoc
     */
    public function parse(string $agent): ResultInterface
    {
        $key = $this->makeHashKey($agent);

        if (!isset($this->runtime[$key])) {
            // In standalone mode, You can run the parser without a cache.
            if ($this->cache !== null) {
                /** @var ResultInterface $result */
                $result = $this->cache->remember(
                    $key,
                    $this->cacheConfig()['interval'],
                    function () use ($agent) {
                        return $this->process($agent);
                    }
                );
            } else {
                $result = $this->process($agent);
            }

            $this->runtime[$key] = $result;
        }

        return $this->runtime[$key];
    }

    /**
     * Create a unique cache key for the user agent.
     *
     * @param  string $agent
     * @return string
     */
    protected function makeHashKey(string $agent): string
    {
        return $this->cacheConfig()['prefix'] . hash('xxh128', $agent);
    }

    /**
     * @return array{interval: int, prefix: string}
     */
    private function cacheConfig(): array
    {
        /** @var array{interval: int, prefix: string} */
        return $this->config['cache'];
    }

    /**
     * @return array{max-header-length: int}
     */
    private function securityConfig(): array
    {
        /** @var array{max-header-length: int} */
        return $this->config['security'];
    }

    /**
     * Pipe the payload through the stages.
     *
     * @param  string $agent
     * @return ResultInterface
     */
    protected function process(string $agent): ResultInterface
    {
        $payload = new Payload($agent);

        foreach ($this->pipeline as $stage) {
            $payload = $stage($payload);
        }

        return new Result($payload->toArray());
    }
}
