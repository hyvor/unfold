<?php

namespace Hyvor\Unfold\Unfolded;

use DateTimeInterface;
use Hyvor\Unfold\Embed\EmbedResponseObject;
use Hyvor\Unfold\Link\Metadata\MetadataKeyType;
use Hyvor\Unfold\Link\Metadata\MetadataObject;
use Hyvor\Unfold\Link\Metadata\MetadataPriority;
use Hyvor\Unfold\UnfoldCallContext;
use Hyvor\Unfold\UnfoldMethod;

class Unfolded
{
    public string $version;

    /**
     * @param UnfoldedAuthor[] $authors
     * @param UnfoldedTag[] $tags
     */
    public function __construct(
        public UnfoldMethod $method,
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
    ) {
        $this->version = '1.0';
    }

    /**
     * @param MetadataObject[] $metadata
     */
    public static function title(array $metadata): ?string
    {
        return self::getMetadataFromKeys($metadata, [
            MetadataKeyType::TITLE,
            MetadataKeyType::OG_TITLE,
            MetadataKeyType::TWITTER_TITLE
        ]);
    }

    /**
     * @param MetadataObject[] $metadata
     */
    public static function description(array $metadata): ?string
    {
        return self::getMetadataFromKeys($metadata, [
            MetadataKeyType::DESCRIPTION,
            MetadataKeyType::OG_DESCRIPTION,
            MetadataKeyType::TWITTER_DESCRIPTION
        ]);
    }

    /**
     * @param MetadataObject[] $metadata
     * @return UnfoldedAuthor[]
     */
    public static function authors(array $metadata): array
    {
        return self::getMetadataFromKeys($metadata, [
            MetadataKeyType::RICH_SCHEMA_AUTHOR,
            MetadataKeyType::OG_ARTICLE_AUTHOR,
            MetadataKeyType::TWITTER_CREATOR
        ], true);
    }

    /**
     * @param MetadataObject[] $metadata
     * @return UnfoldedTag[]
     */
    public static function tags(array $metadata): array
    {
        return self::getMetadataFromKeys($metadata, [
            MetadataKeyType::OG_ARTICLE_TAG
        ], true);
    }

    /**
     * @param MetadataObject[] $metadata
     */
    public static function siteName(array $metadata): ?string
    {
        return self::getMetadataFromKeys($metadata, [
            MetadataKeyType::OG_SITE_NAME,
            MetadataKeyType::TWITTER_SITE
        ]);
    }

    /**
     * @param MetadataObject[] $metadata
     */
    public static function siteUrl(array $metadata): ?string
    {
        return self::getMetadataFromKeys($metadata, [
            MetadataKeyType::OG_URL
        ]);
    }

    /**
     * @param MetadataObject[] $metadata
     */
    public static function canonicalUrl(array $metadata): ?string
    {
        return self::getMetadataFromKeys($metadata, [
            MetadataKeyType::CANONICAL_URL
        ]);
    }

    /**
     * @param MetadataObject[] $metadata
     */
    public static function publishedTime(array $metadata): ?DateTimeInterface
    {
        return self::getMetadataFromKeys($metadata, [
            MetadataKeyType::RICH_SCHEMA_PUBLISHED_TIME,
            MetadataKeyType::OG_ARTICLE_PUBLISHED_TIME
        ]);
    }

    /**
     * @param MetadataObject[] $metadata
     */
    public static function modifiedTime(array $metadata): ?DateTimeInterface
    {
        return self::getMetadataFromKeys($metadata, [
            MetadataKeyType::RICH_SCHEMA_MODIFIED_TIME,
            MetadataKeyType::OG_ARTICLE_MODIFIED_TIME
        ]);
    }

    /**
     * @param MetadataObject[] $metadata
     */
    public static function thumbnailUrl(array $metadata): ?string
    {
        return self::getMetadataFromKeys($metadata, [
            MetadataKeyType::OG_IMAGE,
            MetadataKeyType::OG_IMAGE_URL,
            MetadataKeyType::OG_IMAGE_SECURE_URL,
            MetadataKeyType::TWITTER_IMAGE
        ]);
    }

    /**
     * @param MetadataObject[] $metadata
     */
    public static function iconUrl(array $metadata): ?string
    {
        return self::getMetadataFromKeys($metadata, [
            MetadataKeyType::FAVICON_URL
        ]);
    }

    /**
     * @param MetadataObject[] $metadata
     */
    public static function locale(array $metadata): ?string
    {
        return self::getMetadataFromKeys($metadata, [
            MetadataKeyType::LOCALE,
            MetadataKeyType::OG_LOCALE
        ]);
    }


    // Helpers

    /**
     * @param MetadataObject[] $metadata
     * @param MetadataKeyType[] $keys
     * @return string|DateTimeInterface|UnfoldedAuthor[]|UnfoldedTag[]|null
     */
    public static function getMetadataFromKeys(
        array $metadata,
        array $keys,
        bool $isMultiple = false
    ): string|DateTimeInterface|array|null {
        $value = [];
        /**
         * keyIndex is used track the most priority key found in the metadata
         */
        $keyIndex = count($keys) + 1;

        foreach ($metadata as $meta) {
            if (in_array($meta->key, $keys)) {
                $isNewPriority = $keyIndex > array_search($meta->key, $keys);   // new key with higher priority found
                if (count($value) === 0) {    // if value array is empty add the value
                    $value[] = $meta->value;
                    $keyIndex = array_search($meta->key, $keys);    // set the new key index
                } elseif ($isNewPriority) {    // if a new key with higher priority found add the value to an empty value array
                    $value = [];
                    $value[] = $meta->value;
                    $keyIndex = array_search($meta->key, $keys);    // set the new key index
                } elseif ($isMultiple && ($keyIndex === array_search(
                            $meta->key,
                            $keys
                        ))) {    // if multiple values are allowed and same priority key found
                    $value[] = $meta->value;
                }
            }
            if (!$isMultiple && $keyIndex === 0) {
                break;
            }
        }
        return $isMultiple ?
            $value : // return the array of values
            (
            count($value) !== 0 ?
                $value[0] : // return the first value
                null            // return null if no value found
            );
    }

    /**
     * @param MetadataObject[] $metadata
     */
    public static function fromMetadata(
        string $url,
        array $metadata,
        UnfoldCallContext $context,
    ): self {
        $metadataPriority = new MetadataPriority($metadata);

        return new self(
            $context->method,
            $url,
            null,
            $metadataPriority->title(),
            $metadataPriority->description(),
            $metadataPriority->authors(),
            $metadataPriority->tags(),
            $metadataPriority->siteName(),
            $metadataPriority->siteUrl(),
            $metadataPriority->canonicalUrl(),
            $metadataPriority->publishedTime(),
            $metadataPriority->modifiedTime(),
            $metadataPriority->thumbnailUrl(),
            $metadataPriority->iconUrl(),
            $metadataPriority->locale(),
            $context->duration()
        );
    }

    public static function fromEmbed(
        EmbedResponseObject $embed,
        string $url,
        UnfoldCallContext $context,
    ): self {
        $authors = $embed->author_url || $embed->author_name ?
            [new UnfoldedAuthor($embed->author_name, $embed->author_url)] : [];

        return new self(
            $context->method,
            $url,
            $embed->html,
            $embed->title,
            null,
            $authors,
            [],
            $embed->provider_name,
            $embed->provider_url,
            $embed->url,
            null,
            null,
            $embed->thumbnail_url,
            null,
            null,
            $context->duration()
        );
    }

}
