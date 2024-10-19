<?php

namespace Hyvor\Unfold\Scraper\MetadataParsers;

use Hyvor\Unfold\Scraper\MetadataKey;

class OgParser extends ParserAbstract
{
    public function registerMetaTagsKeys()
    {
        return [
            'og:title' => MetadataKey::OG_TITLE,
            'og:type' => MetadataKey::OG_TYPE,
            'og:image' => MetadataKey::OG_IMAGE,
            'og:url' => MetadataKey::OG_URL,

            'og:audio' => MetadataKey::OG_AUDIO,
            'og:description' => MetadataKey::OG_DESCRIPTION,
            'og:locale' => MetadataKey::OG_LOCALE,
            'og:site_name' => MetadataKey::OG_SITE_NAME,
            'og:video' => MetadataKey::OG_VIDEO,

            'og:image:url' => MetadataKey::OG_IMAGE_URL,
            'og:image:secure_url' => MetadataKey::OG_IMAGE_SECURE_URL,
            'og:image:type' => MetadataKey::OG_IMAGE_TYPE,

            'og:video:secure_url' => MetadataKey::OG_VIDEO_SECURE_URL,
            'og:video:type' => MetadataKey::OG_VIDEO_TYPE,

            'og:audio:secure_url' => MetadataKey::OG_AUDIO_SECURE_URL,
            'og:audio:type' => MetadataKey::OG_AUDIO_TYPE,

            'article:published_time' => MetadataKey::OG_ARTICLE_PUBLISHED_TIME,
            'article:modified_time' => MetadataKey::OG_ARTICLE_MODIFIED_TIME,
            'article:author' => MetadataKey::OG_ARTICLE_AUTHOR,
            'article:tag' => MetadataKey::OG_ARTICLE_TAG
        ];
    }

    public function add(): void
    {}
}