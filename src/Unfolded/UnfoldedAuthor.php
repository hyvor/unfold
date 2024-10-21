<?php

namespace Hyvor\Unfold\Unfolded;

class UnfoldedAuthor
{
    public function __construct(
        public ?string $name = null,
        public ?string $url = null
    ) {
    }
}
