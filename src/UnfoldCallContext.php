<?php

namespace Hyvor\Unfold;

class UnfoldCallContext
{
    public float $startTime;

    public function __construct(
        public UnfoldMethod $method,
        public UnfoldConfigObject $config,
    ) {
        $this->startTime = microtime(true);
    }

    public function duration(): int
    {
        return (microtime(true) - $this->startTime) * 1000;
    }

}
