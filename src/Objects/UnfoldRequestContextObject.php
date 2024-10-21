<?php

namespace Hyvor\Unfold\Objects;

use Hyvor\Unfold\UnfoldConfigObject;
use Hyvor\Unfold\UnfoldMethodEnum;

class UnfoldRequestContextObject
{

    public float $startTime;

    public function __construct(
        public UnfoldMethodEnum $method,
        public UnfoldConfigObject $config,
    ) {
        $this->startTime = microtime(true);
    }

    public function duration(): int
    {
        return (microtime(true) - $this->startTime) * 1000;
    }

}