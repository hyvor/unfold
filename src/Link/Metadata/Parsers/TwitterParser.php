<?php

namespace Hyvor\Unfold\Link\Metadata\Parsers;

class TwitterParser extends ParserAbstract
{
    public function registerMetaTagsKeys()
    {
        return [
            'twitter:card' => MetadataKeyEnum::TWITTER_CARD,
            'twitter:site' => MetadataKeyEnum::TWITTER_SITE,
            'twitter:creator' => MetadataKeyEnum::TWITTER_CREATOR,
            'twitter:description' => MetadataKeyEnum::TWITTER_DESCRIPTION,
            'twitter:title' => MetadataKeyEnum::TWITTER_TITLE,
            'twitter:image' => MetadataKeyEnum::TWITTER_IMAGE,
        ];
    }

    public function add(): void
    {
    }
}
