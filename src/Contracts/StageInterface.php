<?php

namespace hisorange\BrowserDetect\Contracts;

interface StageInterface
{
    /**
     * Process the payload.
     */
    public function __invoke(PayloadInterface $payload): PayloadInterface;
}
