<?php

namespace hisorange\BrowserDetect\Contracts;

/**
 * Interface ParserInterface
 */
interface ParserInterface
{
    /**
     * Get a result object from the current visitor user agent string.
     */
    public function detect(): ResultInterface;

    /**
     * Parse the user agent and provide a result object.
     *
     * @example Browser::parse('Opera/9.80 (Windows NT 6.0) Presto/2.12.388 Version/12.14');
     *
     * @param  string  $agent  User agent string.
     */
    public function parse(string $agent): ResultInterface;

    /**
     * Read the final config for the instance.
     *
     * @return array<string, mixed>
     */
    public function config(): array;
}
