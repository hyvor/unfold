<?php

namespace Hyvor\Unfold\Link\Metadata\Parsers;

use Hyvor\Unfold\Link\Metadata\MetadataKeyType;
use Hyvor\Unfold\Link\Metadata\MetadataObject;

class LinkParser extends ParserAbstract
{
    public function add(): void
    {
        $this->parser->crawler->filterXPath('//link')->each(function ($node) {
            $rel = $node->attr('rel');
            $href = $node->attr('href');

            if (!$rel && !$href) {
                return;
            }

            if ($rel === 'canonical') {
                $this->parser->addMetadata(new MetadataObject(MetadataKeyType::CANONICAL_URL, $href));
            }

            if ($rel === 'icon') {
                $this->parser->addMetadata(new MetadataObject(MetadataKeyType::FAVICON_URL, $href));
            }
        });
    }
}
