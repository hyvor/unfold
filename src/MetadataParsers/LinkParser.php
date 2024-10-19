<?php

namespace Hyvor\Unfold\MetadataParsers;

use Hyvor\Unfold\Objects\MetadataObject;

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
                $this->parser->addMetadata(new MetadataObject(MetadataKeyEnum::CANONICAL_URL, $href));
            }

            if ($rel === 'icon') {
                $this->parser->addMetadata(new MetadataObject(MetadataKeyEnum::FAVICON_URL, $href));
            }
        });
    }
}