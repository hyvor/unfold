<?php

namespace Hyvor\Unfold\Link\Metadata\Parsers;

use Hyvor\Unfold\Objects\MetadataObject;

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

        $this->parser->addMetadata(new MetadataObject(MetadataKeyEnum::LOCALE, $lang));
    }
}
