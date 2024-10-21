<?php

namespace Hyvor\Unfold\Link\Metadata\Parsers;

use Hyvor\Unfold\Link\Metadata\MetadataKeyType;
use Hyvor\Unfold\Link\Metadata\MetadataObject;

class HtmlLangParser extends ParserAbstract
{
    public function add(): void
    {
        $htmlNode = $this->parser->crawler->filterXPath('//html');

        if ($htmlNode->count() === 0) {
            return;
        }

        $lang = $htmlNode->attr('lang');
        if (!$lang) {
            return;
        }
        $lang = trim($lang);

        $this->parser->addMetadata(new MetadataObject(MetadataKeyType::LOCALE, $lang));
    }
}
