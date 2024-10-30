<?php

namespace Hyvor\Unfold\Link\Metadata\Parsers;

use Hyvor\Unfold\Link\Metadata\MetadataKeyType;
use Hyvor\Unfold\Link\Metadata\MetadataObject;
use Hyvor\Unfold\Link\Metadata\RelativeUrl;

class LinkParser extends ParserAbstract
{
    public function add(): void
    {
        $this->parser->crawler->filterXPath('//link')->each(function ($node) {
            $rel = $node->attr('rel');
            $href = $node->attr('href');

            if ($rel === 'canonical' && is_string($href)) {
                $this->parser->addMetadata(
                    new MetadataObject(
                        MetadataKeyType::CANONICAL_URL,
                        RelativeUrl::resolve($href, $this->parser->config->url),
                    )
                );
            }

            if ($rel === 'icon' && is_string($href)) {
                $this->parser->addMetadata(
                    new MetadataObject(
                        MetadataKeyType::FAVICON_URL,
                        RelativeUrl::resolve($href, $this->parser->config->url),
                    )
                );
            }
        });
    }

}
