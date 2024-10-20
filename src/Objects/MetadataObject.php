<?php

namespace Hyvor\Unfold\Objects;

use Hyvor\Unfold\MetadataParsers\MetadataKeyEnum;
use DateTimeInterface;

class MetadataObject
{
    public function __construct(
        public MetadataKeyEnum $key,
        public string|DateTimeInterface|AuthorObject|TagObject $value,
    ) {
    }
}
