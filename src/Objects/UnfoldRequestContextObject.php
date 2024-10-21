<?php

namespace Hyvor\Unfold\Objects;

use Hyvor\Unfold\UnfoldConfigObject;
use Hyvor\Unfold\UnfoldMethod;

class UnfoldRequestContextObject
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
