<?php

namespace Hyvor\Unfold\Scraper\MetadataParsers;

use Hyvor\Unfold\Scraper\MetadataKey;

class TwitterParser extends ParserAbstract
{

    function add(): void
    {
        $this->parser->addMetadataFromMetaTags([
            'twitter:card' => MetadataKey::TWITTER_CARD,
            'twitter:site' => MetadataKey::TWITTER_SITE,
            'twitter:creator' => MetadataKey::TWITTER_CREATOR,
            'twitter:description' => MetadataKey::TWITTER_DESCRIPTION,
            'twitter:title' => MetadataKey::TWITTER_TITLE,
            'twitter:image' => MetadataKey::TWITTER_IMAGE,
        ]);
    }
}