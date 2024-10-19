<?php

namespace Hyvor\Unfold\Objects;

class AuthorObject
{
    public function __construct(
        public ?string $name,
        public ?string $url
    )
    {
    }
}