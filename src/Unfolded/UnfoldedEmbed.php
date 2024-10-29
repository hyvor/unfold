<?php

namespace Hyvor\Unfold\Unfolded;

class UnfoldedEmbed
{
    public string $version = '1.0';

    public function __construct(
        public string $url,
        public string $embed,
        public int $durationMs
    ) {
    }

}
