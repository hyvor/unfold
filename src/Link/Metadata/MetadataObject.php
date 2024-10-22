<?php

namespace Hyvor\Unfold\Link\Metadata;


use Hyvor\Unfold\Unfolded\UnfoldedAuthor;
use Hyvor\Unfold\Unfolded\UnfoldedTag;

/**
 * @template T of string|\DateTimeInterface|UnfoldedAuthor|UnfoldedTag = string
 */
class MetadataObject
{

    /**
     * @param MetadataKeyType $key
     * @param T $value
     */
    public function __construct(
        public MetadataKeyType $key,
        public $value,
    ) {
    }
}
