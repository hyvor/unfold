<?php

namespace Hyvor\Unfold\Link\Metadata;

use Hyvor\Unfold\Unfolded\UnfoldedAuthor;
use Hyvor\Unfold\Unfolded\UnfoldedTag;

enum MetadataKeyType
{
    case TITLE;

    case DESCRIPTION;
    case FAVICON_URL;
    case LOCALE;
    case CANONICAL_URL;

    case RICH_SCHEMA_PUBLISHED_TIME;
    case RICH_SCHEMA_MODIFIED_TIME;
    case RICH_SCHEMA_AUTHOR;

    case OG_TITLE;
    case OG_TYPE;
    case OG_IMAGE;
    case OG_URL;

    case OG_AUDIO;
    case OG_DESCRIPTION;
    case OG_LOCALE;
    case OG_SITE_NAME;
    case OG_VIDEO;

    case OG_IMAGE_URL;
    case OG_IMAGE_SECURE_URL;
    case OG_IMAGE_TYPE;


    case OG_VIDEO_SECURE_URL;
    case OG_VIDEO_TYPE;

    case OG_AUDIO_SECURE_URL;
    case OG_AUDIO_TYPE;

    case OG_ARTICLE_PUBLISHED_TIME;
    case OG_ARTICLE_MODIFIED_TIME;
    case OG_ARTICLE_AUTHOR;
    case OG_ARTICLE_TAG;

    case TWITTER_CARD;
    case TWITTER_SITE;
    case TWITTER_CREATOR;
    case TWITTER_DESCRIPTION;
    case TWITTER_TITLE;
    case TWITTER_IMAGE;

    /**
     * Gets the value of the metadata from a given content string
     * ex: article:published_time is converted to DateTimeInterface
     */
    public function getValue(string $content)
    {
        if (
            $this === MetadataKeyType::OG_ARTICLE_PUBLISHED_TIME ||
            $this === MetadataKeyType::OG_ARTICLE_MODIFIED_TIME
        ) {
            return $this->getDateTimeFromString($content);
        }

        if (
            $this === MetadataKeyType::OG_ARTICLE_AUTHOR ||
            $this === MetadataKeyType::TWITTER_CREATOR
        ) {
            return $this->getAuthorFromString($content);
        }

        if ($this === MetadataKeyType::OG_ARTICLE_TAG) {
            return new UnfoldedTag($content);
        }

        return $content;
    }

    private function getDateTimeFromString(string $value): ?\DateTimeInterface
    {
        try {
            return new \DateTimeImmutable($value);
        } catch (\Exception) {
            return null;
        }
    }

    private function getAuthorFromString(string $value): UnfoldedAuthor
    {
        if (str_contains($value, 'http://') || str_contains($value, 'https://')) {
            return new UnfoldedAuthor(null, $value);
        } else {
            return new UnfoldedAuthor($value, null);
        }
    }
}
