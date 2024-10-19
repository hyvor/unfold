<?php

namespace Hyvor\Unfold\MetadataParsers;

class DescriptionParser extends ParserAbstract
{
    public function registerMetaTagsKeys()
    {
        return [
            'description' => MetadataKeyEnum::DESCRIPTION,
        ];
    }
    public function add(): void
    {}
}