<?php

namespace Hyvor\Unfold\Types;

class Author
{
    public function __construct(
        public ?string $name,
        public ?string $url
    )
    {
    }
}