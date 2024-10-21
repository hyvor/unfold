<?php

namespace Hyvor\Unfold\Link\Metadata\Parsers;

class DescriptionParser extends ParserAbstract
{
    public function registerMetaTagsKeys()
    {
        return [
            'description' => MetadataKeyEnum::DESCRIPTION,
        ];
    }

    public function add(): void
    {
    }
}
