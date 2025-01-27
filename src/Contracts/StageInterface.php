<?php

namespace hisorange\BrowserDetect\Contracts;

interface StageInterface
{
    /**
     * Process the payload.
     *
     * @param  PayloadInterface $payload
     * @return PayloadInterface
     */
    public function __invoke(PayloadInterface $payload): PayloadInterface;
}
