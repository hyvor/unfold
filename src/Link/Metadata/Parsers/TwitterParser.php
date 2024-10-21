<?php

namespace Hyvor\Unfold\Link\Metadata\Parsers;

use Hyvor\Unfold\Link\Metadata\MetadataKeyType;

class TwitterParser extends ParserAbstract
{
    public function registerMetaTagsKeys()
    {
        return [
            'twitter:card' => MetadataKeyType::TWITTER_CARD,
            'twitter:site' => MetadataKeyType::TWITTER_SITE,
            'twitter:creator' => MetadataKeyType::TWITTER_CREATOR,
            'twitter:description' => MetadataKeyType::TWITTER_DESCRIPTION,
            'twitter:title' => MetadataKeyType::TWITTER_TITLE,
            'twitter:image' => MetadataKeyType::TWITTER_IMAGE,
        ];
    }

    public function add(): void
    {
    }
}
