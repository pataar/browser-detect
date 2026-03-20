<?php

namespace Pataar\BrowserDetect;

use Pataar\BrowserDetect\Contracts\PayloadInterface;

/**
 * This class is passed down in the pipeline,
 * and each stage makes the changes on this
 * state carrier object.
 */
class Payload implements PayloadInterface
{
    /**
     * @var string
     */
    protected $agent;

    /**
     * @var array<string, mixed>
     */
    protected $store = [];

    /**
     * {@inheritdoc}
     */
    public function __construct(string $agent)
    {
        $this->agent = $agent;
    }

    /**
     * {@inheritdoc}
     */
    public function getAgent(): string
    {
        return $this->agent;
    }

    /**
     * {@inheritdoc}
     */
    public function getValue(string $key)
    {
        return $this->store[$key] ?? null;
    }

    /**
     * {@inheritdoc}
     */
    public function setValue(string $key, $value): void
    {
        if ($value !== null) {
            $this->store[$key] = $value;
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_merge(
            $this->store,
            [
                'userAgent' => $this->agent,
            ]
        );
    }
}
