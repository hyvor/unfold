<?php

namespace Hyvor\Unfold\Link\Metadata\Parsers;

use Hyvor\Unfold\Link\Metadata\MetadataKeyType;

class OgParser extends ParserAbstract
{
    public function registerMetaTagsKeys()
    {
        return [
            'og:title' => MetadataKeyType::OG_TITLE,
            'og:type' => MetadataKeyType::OG_TYPE,
            'og:image' => MetadataKeyType::OG_IMAGE,
            'og:url' => MetadataKeyType::OG_URL,

            'og:audio' => MetadataKeyType::OG_AUDIO,
            'og:description' => MetadataKeyType::OG_DESCRIPTION,
            'og:locale' => MetadataKeyType::OG_LOCALE,
            'og:site_name' => MetadataKeyType::OG_SITE_NAME,
            'og:video' => MetadataKeyType::OG_VIDEO,

            'og:image:url' => MetadataKeyType::OG_IMAGE_URL,
            'og:image:secure_url' => MetadataKeyType::OG_IMAGE_SECURE_URL,
            'og:image:type' => MetadataKeyType::OG_IMAGE_TYPE,

            'og:video:secure_url' => MetadataKeyType::OG_VIDEO_SECURE_URL,
            'og:video:type' => MetadataKeyType::OG_VIDEO_TYPE,

            'og:audio:secure_url' => MetadataKeyType::OG_AUDIO_SECURE_URL,
            'og:audio:type' => MetadataKeyType::OG_AUDIO_TYPE,

            'article:published_time' => MetadataKeyType::OG_ARTICLE_PUBLISHED_TIME,
            'article:modified_time' => MetadataKeyType::OG_ARTICLE_MODIFIED_TIME,
            'article:author' => MetadataKeyType::OG_ARTICLE_AUTHOR,
            'article:tag' => MetadataKeyType::OG_ARTICLE_TAG
        ];
    }

    public function add(): void
    {
    }
}
