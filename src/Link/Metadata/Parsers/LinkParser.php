<?php

namespace Hyvor\Unfold\Link\Metadata\Parsers;

use Hyvor\Unfold\Link\Metadata\MetadataKeyType;
use Hyvor\Unfold\Link\Metadata\MetadataObject;
use League\Uri\Uri;

class LinkParser extends ParserAbstract
{
    public function add(): void
    {
        $this->parser->crawler->filterXPath('//link')->each(function ($node) {
            $rel = $node->attr('rel');
            $href = $node->attr('href');

            if ($rel === 'canonical' && is_string($href)) {
                $this->parser->addMetadata(new MetadataObject(MetadataKeyType::CANONICAL_URL, $this->fixIfRelativeUrl($href)));
            }

            if ($rel === 'icon' && is_string($href)) {
                $this->parser->addMetadata(new MetadataObject(MetadataKeyType::FAVICON_URL, $this->fixIfRelativeUrl($href)));
            }
        });
    }

    public function fixIfRelativeUrl(string $url): string
    {
        $parsedUrl = parse_url($url);
        if (isset($parsedUrl['host'])) {
            return $url;
        } else {
            return Uri::fromBaseUri($url, $this->parser->context->url)->toString();
        }
    }
}
