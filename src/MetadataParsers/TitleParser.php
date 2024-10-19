<?php

namespace Hyvor\Unfold\MetadataParsers;

use Hyvor\Unfold\Objects\MetadataObject;

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

        $this->parser->addMetadata(new MetadataObject(MetadataKeyEnum::TITLE, $title));
    }
}