<?php

namespace Hyvor\Unfold\Link\MetadataParsers;

class OgParser extends ParserAbstract
{
    public function registerMetaTagsKeys()
    {
        return [
            'og:title' => MetadataKeyEnum::OG_TITLE,
            'og:type' => MetadataKeyEnum::OG_TYPE,
            'og:image' => MetadataKeyEnum::OG_IMAGE,
            'og:url' => MetadataKeyEnum::OG_URL,

            'og:audio' => MetadataKeyEnum::OG_AUDIO,
            'og:description' => MetadataKeyEnum::OG_DESCRIPTION,
            'og:locale' => MetadataKeyEnum::OG_LOCALE,
            'og:site_name' => MetadataKeyEnum::OG_SITE_NAME,
            'og:video' => MetadataKeyEnum::OG_VIDEO,

            'og:image:url' => MetadataKeyEnum::OG_IMAGE_URL,
            'og:image:secure_url' => MetadataKeyEnum::OG_IMAGE_SECURE_URL,
            'og:image:type' => MetadataKeyEnum::OG_IMAGE_TYPE,

            'og:video:secure_url' => MetadataKeyEnum::OG_VIDEO_SECURE_URL,
            'og:video:type' => MetadataKeyEnum::OG_VIDEO_TYPE,

            'og:audio:secure_url' => MetadataKeyEnum::OG_AUDIO_SECURE_URL,
            'og:audio:type' => MetadataKeyEnum::OG_AUDIO_TYPE,

            'article:published_time' => MetadataKeyEnum::OG_ARTICLE_PUBLISHED_TIME,
            'article:modified_time' => MetadataKeyEnum::OG_ARTICLE_MODIFIED_TIME,
            'article:author' => MetadataKeyEnum::OG_ARTICLE_AUTHOR,
            'article:tag' => MetadataKeyEnum::OG_ARTICLE_TAG
        ];
    }

    public function add(): void
    {
    }
}
