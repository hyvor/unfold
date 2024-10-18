<?php

namespace Hyvor\Unfold\Scraper;

class Metadata
{
    public function __construct(
        public MetadataKey $key,
        public string $value,
    ) {}
}