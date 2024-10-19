<?php

namespace Hyvor\Unfold\Objects;

class AuthorObject
{
    public function __construct(
        public ?string $name = null,
        public ?string $url = null
    )
    {
    }
}