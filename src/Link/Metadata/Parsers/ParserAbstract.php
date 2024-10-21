<?php

namespace Hyvor\Unfold\Link\Metadata\Parsers;

use Hyvor\Unfold\Link\Metadata\MetadataKeyType;
use Hyvor\Unfold\Link\Metadata\MetadataParser;

abstract class ParserAbstract
{
    public function __construct(
        protected MetadataParser $parser
    ) {
    }

    /**
     * @return array<string, MetadataKeyType>
     */
    public function registerMetaTagsKeys()
    {
        return [];
    }

    /**
     * This should call $this->parser->addMetadata() to add each metadata
     */
    abstract public function add(): void;

}
