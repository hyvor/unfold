<?php

namespace Hyvor\Unfold\Link\Metadata;

use DateTimeInterface;
use Hyvor\Unfold\Unfolded\UnfoldedAuthor;
use Hyvor\Unfold\Unfolded\UnfoldedTag;

class MetadataObject
{
    public function __construct(
        public MetadataKeyType $key,
        public string|DateTimeInterface|UnfoldedAuthor|UnfoldedTag $value,
    ) {
    }
}
