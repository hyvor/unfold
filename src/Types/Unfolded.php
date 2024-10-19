<?php

namespace Hyvor\Unfold\Types;

use DateTimeInterface;
use Hyvor\Unfold\Scraper\Metadata;
use Hyvor\Unfold\Scraper\MetadataKey;
use DateTimeImmutable;
use Exception;
class Unfolded
{
    public string $version;

    /**
     * @param Author[] $authors
     * @param Tag[] $tags
     */
    public function __construct(
        public Method  $method,
        public string $url,

        public ?string $embed,
        public ?string $title,
        public ?string $description,
        public array $authors,
        public array $tags,
        public ?string $siteName,
        public ?string $siteUrl,
        public ?string $canonicalUrl,
        public ?DateTimeInterface $publishedTime,
        public ?DateTimeInterface $modifiedTime,
        public ?string $thumbnailUrl,
        public ?string $iconUrl,
        public ?string $locale,

        public int $durationMs
    )
    {
        $this->version = '1.0';
    }

    /**
     * @param Metadata[] $metadata
     */
    public static function title(array $metadata): ?string
    {
        return self::getMetadataFromKeys($metadata, [
            MetadataKey::TITLE,
            MetadataKey::OG_TITLE,
            MetadataKey::TWITTER_TITLE
        ]);
    }

    /**
     * @param Metadata[] $metadata
     */
    public static function description(array $metadata): ?string
    {
        return self::getMetadataFromKeys($metadata, [
            MetadataKey::DESCRIPTION,
            MetadataKey::OG_DESCRIPTION,
            MetadataKey::TWITTER_DESCRIPTION
        ]);
    }

    /**
     * @param Metadata[] $metadata
     */
    public static function authors(array $metadata): array
    {
        $authors = [];
        foreach ($metadata as $meta) {
            if ($meta->key === MetadataKey::OG_ARTICLE_AUTHOR) {
                if (str_contains($meta->value, 'http://') || str_contains($meta->value, 'https://')) {
                    $authors[] = new Author(null, $meta->value);
                } else {
                    $authors[] = new Author($meta->value, null);
                }
            } elseif ($meta->key === MetadataKey::TWITTER_CREATOR) {
                $authors[] = new Author($meta->value, null);
            }
        }
        return $authors;
    }

    /**
     * @param Metadata[] $metadata
     */
    public static function siteName(array $metadata): ?string
    {
        return self::getMetadataFromKeys($metadata, [
            MetadataKey::OG_SITE_NAME,
            MetadataKey::TWITTER_SITE
        ]);
    }

    /**
     * @param Metadata[] $metadata
     */
    public static function siteUrl(array $metadata): ?string
    {
        return self::getMetadataFromKeys($metadata, [
            MetadataKey::OG_URL
        ]);
    }

    /**
     * @param Metadata[] $metadata
     */
    public static function canonicalUrl(array $metadata): ?string
    {
        return self::getMetadataFromKeys($metadata, [
            MetadataKey::CANONICAL_URL
        ]);
    }

    /**
     * @param Metadata[] $metadata
     */
    public static function publishedTime(array $metadata): ?DateTimeInterface
    {
        return self::getDateTimeFromString(self::getMetadataFromKeys($metadata, [
            MetadataKey::OG_ARTICLE_PUBLISHED_TIME
        ]));
    }

    /**
     * @param Metadata[] $metadata
     */
    public static function modifiedTime(array $metadata): ?DateTimeInterface
    {
        return self::getDateTimeFromString(self::getMetadataFromKeys($metadata, [
            MetadataKey::OG_ARTICLE_MODIFIED_TIME
        ]));
    }

    /**
     * @param Metadata[] $metadata
     */
    public static function thumbnailUrl(array $metadata): ?string
    {
        return self::getMetadataFromKeys($metadata, [
            MetadataKey::OG_IMAGE,
            MetadataKey::OG_IMAGE_URL,
            MetadataKey::OG_IMAGE_SECURE_URL,
            MetadataKey::TWITTER_IMAGE
        ]);
    }

    /**
     * @param Metadata[] $metadata
     */
    public static function iconUrl(array $metadata): ?string
    {
        return self::getMetadataFromKeys($metadata, [
            MetadataKey::FAVICON
        ]);
    }

    /**
     * @param Metadata[] $metadata
     */
    public static function locale(array $metadata): ?string
    {
        return self::getMetadataFromKeys($metadata, [
            MetadataKey::LOCALE,
            MetadataKey::OG_LOCALE
        ]);
    }

    // Helpers
    /**
     * @param Metadata[] $metadata
     * @param MetadataKey[] $keys
     */
    public static function getMetadataFromKeys(array $metadata, array $keys): ?string
    {
        $value = null;
        /**
         * keyIndex is used track the most priority key found in the metadata
         */
        $keyIndex = count($keys) + 1;

        foreach ($metadata as $meta) {
            if (in_array($meta->key, $keys)) {
                if (!$value || $keyIndex > array_search($meta->key, $keys)) {
                    $value = $meta->value;
                    $keyIndex = array_search($meta->key, $keys);
                }
            }
            if ($keyIndex === 0) {
                break;
            }
        }
        return $value;
    }

    public static function getDateTimeFromString(?string $value): ?DateTimeInterface
    {
        if (!$value) {
            return null;
        }

        try {
            return new DateTimeImmutable($value);
        } catch (Exception) {
            return null;
        }
    }
}