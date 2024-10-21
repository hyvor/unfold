<?php

namespace Hyvor\Unfold\Objects;

use DateTimeInterface;
use Hyvor\Unfold\Link\MetadataParsers\MetadataKeyEnum;

class MetadataObject
{
    public function __construct(
        public MetadataKeyEnum $key,
        public string|DateTimeInterface|AuthorObject|TagObject $value,
    ) {
    }
}
