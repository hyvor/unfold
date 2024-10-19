<?php

namespace Hyvor\Unfold\Scraper\MetadataParsers;

use Hyvor\Unfold\Scraper\MetadataKey;
use Hyvor\Unfold\Scraper\MetadataParser;

abstract class ParserAbstract
{

    public function __construct(
        protected MetadataParser $parser
    )
    {}

    /**
     * @return array<string, MetadataKey>
     */
    public function registerMetaTagsKeys()
    {
        return [];
    }

    /**
     * This should call $this->parser->addMetadata() to add each metadata
     */
    abstract public function add() : void;

}