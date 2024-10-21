<?php

namespace Hyvor\Unfold\Link\Metadata\Parsers;

use Hyvor\Unfold\Link\Metadata\MetadataKeyType;
use Hyvor\Unfold\Link\Metadata\MetadataObject;

class TitleParser extends ParserAbstract
{
    public function add(): void
    {
        $titleNode = $this->parser->crawler->filterXPath('//title');

        if ($titleNode->count() === 0) {
            return;
        }

        $title = $titleNode->text();
        $title = trim($title);

        if ($title === '') {
            return;
        }

        $this->parser->addMetadata(new MetadataObject(MetadataKeyType::TITLE, $title));
    }
}
