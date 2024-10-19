<?php

namespace Hyvor\Unfold\Scraper\MetadataParsers;

use Hyvor\Unfold\Scraper\Metadata;
use Hyvor\Unfold\Scraper\MetadataParser;
use Symfony\Component\DomCrawler\Crawler;

abstract class ParserAbstract
{

    public function __construct(
        protected MetadataParser $parser
    )
    {}

    /**
     * This should call $this->parser->addMetadata() to add each metadata
     */
    abstract function add() : void;

}