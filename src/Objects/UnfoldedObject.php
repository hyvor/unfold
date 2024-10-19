<?php

namespace Hyvor\Unfold\Objects;

use DateTimeImmutable;
use DateTimeInterface;
use Exception;
use Hyvor\Unfold\MetadataParsers\MetadataKeyEnum;
use Hyvor\Unfold\UnfoldMethodEnum;

class UnfoldedObject
{
    public string $version;

    /**
     * @param AuthorObject[] $authors
     * @param TagObject[] $tags
     */
    public function __construct(
        public UnfoldMethodEnum $method,
        public string           $url,

        public ?string          $embed,
        public ?string          $title,
        public ?string          $description,
        public array            $authors,
        public array            $tags,
        public ?string          $siteName,
        public ?string          $siteUrl,
        public ?string          $canonicalUrl,
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
     * @param MetadataObject[] $metadata
     */
    public static function title(array $metadata): ?string
    {
        return self::getMetadataFromKeys($metadata, [
            MetadataKeyEnum::TITLE,
            MetadataKeyEnum::OG_TITLE,
            MetadataKeyEnum::TWITTER_TITLE
        ]);
    }

    /**
     * @param MetadataObject[] $metadata
     */
    public static function description(array $metadata): ?string
    {
        return self::getMetadataFromKeys($metadata, [
            MetadataKeyEnum::DESCRIPTION,
            MetadataKeyEnum::OG_DESCRIPTION,
            MetadataKeyEnum::TWITTER_DESCRIPTION
        ]);
    }

    /**
     * @param MetadataObject[] $metadata
     * @return AuthorObject[]
     */
    public static function authors(array $metadata): array
    {
        $authors = [];
        foreach ($metadata as $meta) {
            if ($meta->key === MetadataKeyEnum::OG_ARTICLE_AUTHOR) {
                if (str_contains($meta->value, 'http://') || str_contains($meta->value, 'https://')) {
                    $authors[] = new AuthorObject(null, $meta->value);
                } else {
                    $authors[] = new AuthorObject($meta->value, null);
                }
            } elseif ($meta->key === MetadataKeyEnum::TWITTER_CREATOR) {
                $authors[] = new AuthorObject($meta->value, null);
            }
        }
        return $authors;
    }

    /**
     * @param MetadataObject[] $metadata
     * @return TagObject[]
     */
    public static function tags(array $metadata): array
    {
        $tags = [];
        foreach ($metadata as $meta) {
            if ($meta->key === MetadataKeyEnum::OG_ARTICLE_TAG) {
                $tags[] = new TagObject($meta->value);
            }
        }
        return $tags;
    }

    /**
     * @param MetadataObject[] $metadata
     */
    public static function siteName(array $metadata): ?string
    {
        return self::getMetadataFromKeys($metadata, [
            MetadataKeyEnum::OG_SITE_NAME,
            MetadataKeyEnum::TWITTER_SITE
        ]);
    }

    /**
     * @param MetadataObject[] $metadata
     */
    public static function siteUrl(array $metadata): ?string
    {
        return self::getMetadataFromKeys($metadata, [
            MetadataKeyEnum::OG_URL
        ]);
    }

    /**
     * @param MetadataObject[] $metadata
     */
    public static function canonicalUrl(array $metadata): ?string
    {
        return self::getMetadataFromKeys($metadata, [
            MetadataKeyEnum::CANONICAL_URL
        ]);
    }

    /**
     * @param MetadataObject[] $metadata
     */
    public static function publishedTime(array $metadata): ?DateTimeInterface
    {
        return self::getDateTimeFromString(self::getMetadataFromKeys($metadata, [
            MetadataKeyEnum::OG_ARTICLE_PUBLISHED_TIME
        ]));
    }

    /**
     * @param MetadataObject[] $metadata
     */
    public static function modifiedTime(array $metadata): ?DateTimeInterface
    {
        return self::getDateTimeFromString(self::getMetadataFromKeys($metadata, [
            MetadataKeyEnum::OG_ARTICLE_MODIFIED_TIME
        ]));
    }

    /**
     * @param MetadataObject[] $metadata
     */
    public static function thumbnailUrl(array $metadata): ?string
    {
        return self::getMetadataFromKeys($metadata, [
            MetadataKeyEnum::OG_IMAGE,
            MetadataKeyEnum::OG_IMAGE_URL,
            MetadataKeyEnum::OG_IMAGE_SECURE_URL,
            MetadataKeyEnum::TWITTER_IMAGE
        ]);
    }

    /**
     * @param MetadataObject[] $metadata
     */
    public static function iconUrl(array $metadata): ?string
    {
        return self::getMetadataFromKeys($metadata, [
            MetadataKeyEnum::FAVICON_URL
        ]);
    }

    /**
     * @param MetadataObject[] $metadata
     */
    public static function locale(array $metadata): ?string
    {
        return self::getMetadataFromKeys($metadata, [
            MetadataKeyEnum::LOCALE,
            MetadataKeyEnum::OG_LOCALE
        ]);
    }

    // Helpers
    /**
     * @param MetadataObject[] $metadata
     * @param MetadataKeyEnum[] $keys
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