<?php

namespace Hyvor\Unfold\MetadataParsers;

abstract class ParserAbstract
{

    public function __construct(
        protected MetadataParser $parser
    )
    {}

    /**
     * @return array<string, MetadataKeyEnum>
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