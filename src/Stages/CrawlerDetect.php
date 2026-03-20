<?php

namespace Pataar\BrowserDetect\Stages;

use Pataar\BrowserDetect\Contracts\PayloadInterface;
use Pataar\BrowserDetect\Contracts\StageInterface;

/**
 * Checks if the user agent belongs to bot or crawler.
 */
class CrawlerDetect implements StageInterface
{
    protected ?\Jaybizzle\CrawlerDetect\CrawlerDetect $crawler = null;

    public function __invoke(PayloadInterface $payload): PayloadInterface
    {
        $this->crawler ??= new \Jaybizzle\CrawlerDetect\CrawlerDetect(
            ['HTTP_FAKE_HEADER' => 'Crawler\Detect']
        );
        $this->crawler->setUserAgent($payload->getAgent());
        $payload->setValue('isBot', $this->crawler->isCrawler());

        return $payload;
    }
}
