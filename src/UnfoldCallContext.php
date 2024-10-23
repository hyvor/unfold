<?php

namespace Hyvor\Unfold;

class UnfoldCallContext
{
    public float $startTime;

    public function __construct(
        public string $url,
        public UnfoldMethod $method,
        public UnfoldConfig $config,
    ) {
        $this->startTime = microtime(true);
    }

    public function duration(): int
    {
        return (int)((microtime(true) - $this->startTime) * 1000);
    }

}
