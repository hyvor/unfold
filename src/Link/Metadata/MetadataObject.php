<?php

namespace Hyvor\Unfold\Link\Metadata;


/**
 * @template T extends string|DateTimeInterface|UnfoldedAuthor|UnfoldedTag
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
