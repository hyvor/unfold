<?php

namespace Hyvor\Unfold\Objects;

use DateTimeInterface;
use Hyvor\Unfold\Link\Metadata\Parsers\MetadataKeyEnum;
use Hyvor\Unfold\Unfolded\UnfoldedAuthor;
use Hyvor\Unfold\Unfolded\UnfoldedTag;

class MetadataObject
{
    public function __construct(
        public MetadataKeyEnum $key,
        public string|DateTimeInterface|UnfoldedAuthor|UnfoldedTag $value,
    ) {
    }
}
