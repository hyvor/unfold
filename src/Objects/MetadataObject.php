<?php

namespace Hyvor\Unfold\Objects;

use Hyvor\Unfold\MetadataParsers\MetadataKeyEnum;

class MetadataObject
{
    public function __construct(
        public MetadataKeyEnum $key,
        public string          $value,
    ) {}
}