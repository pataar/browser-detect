<?php

namespace hisorange\BrowserDetect\Stages;

use hisorange\BrowserDetect\Contracts\StageInterface;
use hisorange\BrowserDetect\Contracts\PayloadInterface;

/**
 * Checks if the user agent belongs to bot or crawler.
 *
 * @package hisorange\BrowserDetect\Stages
 */
class CrawlerDetect implements StageInterface
{
    protected ?\Jaybizzle\CrawlerDetect\CrawlerDetect $crawler = null;

    /**
     * @param  PayloadInterface $payload
     * @return PayloadInterface
     */
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
