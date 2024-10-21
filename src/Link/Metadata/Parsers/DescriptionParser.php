<?php

namespace Hyvor\Unfold\Link\Metadata\Parsers;

use Hyvor\Unfold\Link\Metadata\MetadataKeyType;

class DescriptionParser extends ParserAbstract
{
    public function registerMetaTagsKeys()
    {
        return [
            'description' => MetadataKeyType::DESCRIPTION,
        ];
    }

    public function add(): void
    {
    }
}
