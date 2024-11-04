<?php

namespace Hyvor\Unfold\Link\Metadata;

use Hyvor\Unfold\Unfolded\UnfoldedAuthor;
use DateTimeInterface;
use Hyvor\Unfold\Unfolded\UnfoldedTag;

/**
 * This class select the best metadata to use in the UnfoldedLink object
 */
class MetadataPriority
{
    /**
     * @param MetadataObject[] $metadata
     */
    public function __construct(private array $metadata)
    {
    }

    /**
     * @param MetadataKeyType[] $keys
     * @return mixed[]
     */
    private function prioritizedAll(array $keys)
    {
        $keyedMetadata = [];

        /**
         * First, we group the metadata by their key and filters metadata we don't want
         * Each key may have multiple metadata
         *
         * [
         *     'OG_TITLE' => [MetadataObject],
         *     'TITLE' => [MetadataObject, MetadataObject],
         * ]
         */
        foreach ($this->metadata as $metadata) {
            $key = $metadata->key;
            if (!in_array($key, $keys)) {
                continue;
            }

            $keyName = $key->name;
            if (isset($keyedMetadata[$keyName])) {
                $keyedMetadata[$keyName][] = $metadata;
            } else {
                $keyedMetadata[$keyName] = [$metadata];
            }
        }

        /**
         * Next, we are sorting $keyedMetadata by the order of $keys
         * If $keys was [TITLE, OG_TITLE], then the order of $keyedMetadata will be
         * [
         *    'TITLE' => [MetadataObject, MetadataObject],
         *    'OG_TITLE' => [MetadataObject],
         * ]
         */
        $keysNames = array_map(fn($key) => $key->name, $keys);
        uksort($keyedMetadata, function ($a, $b) use ($keysNames) {
            return intval(array_search($a, $keysNames)) - intval(array_search($b, $keysNames));
        });

        // index by 0,1,2
        $keyedMetadata = array_values($keyedMetadata);
        // return the values
        return array_map(fn($metadata) => $metadata->value, $keyedMetadata[0] ?? []);
    }

    /**
     * @param MetadataKeyType[] $keys
     * @return mixed|null
     */
    private function prioritized(array $keys)
    {
        return $this->prioritizedAll($keys)[0] ?? null;
    }

    public function title(): ?string
    {
        /** @var string|null */
        return $this->prioritized(
            [
                MetadataKeyType::TITLE,
                MetadataKeyType::OG_TITLE,
                MetadataKeyType::TWITTER_TITLE
            ]
        );
    }

    public function description(): ?string
    {
        /** @var string|null */
        return $this->prioritized([
            MetadataKeyType::DESCRIPTION,
            MetadataKeyType::OG_DESCRIPTION,
            MetadataKeyType::TWITTER_DESCRIPTION
        ]);
    }

    /**
     * @return UnfoldedAuthor[]
     */
    public function authors()
    {
        /** @var UnfoldedAuthor[] */
        return $this->prioritizedAll([
            MetadataKeyType::RICH_SCHEMA_AUTHOR,
            MetadataKeyType::OG_ARTICLE_AUTHOR,
            MetadataKeyType::TWITTER_CREATOR
        ]);
    }

    /**
     * @return UnfoldedTag[]
     */
    public function tags(): array
    {
        /** @var UnfoldedTag[] */
        return $this->prioritizedAll([
            MetadataKeyType::OG_ARTICLE_TAG
        ]);
    }


    public function siteName(): ?string
    {
        /** @var string|null */
        return $this->prioritized([
            MetadataKeyType::OG_SITE_NAME,
            // MetadataKeyType::TWITTER_SITE
        ]);
    }


    public function siteUrl(string $url): ?string
    {
        /** @var string|null $currentUrl */
        $currentUrl = $this->prioritized([
            MetadataKeyType::CANONICAL_URL,
            MetadataKeyType::OG_URL
        ]);
        $currentUrl = $currentUrl ?? $url;

        // get origin from url
        $parsedUrl = parse_url($currentUrl);
        if ($parsedUrl !== false) {
            $scheme = $parsedUrl['scheme'] ?? 'http';
            $host = $parsedUrl['host'] ?? '';
            return $host ? $scheme . '://' . $host : null;
        }

        return null; // @codeCoverageIgnore
    }


    public function canonicalUrl(): ?string
    {
        /** @var string|null */
        return $this->prioritized([
            MetadataKeyType::CANONICAL_URL,
            MetadataKeyType::OG_URL
        ]);
    }


    public function publishedTime(): ?DateTimeInterface
    {
        /** @var ?DateTimeInterface */
        return $this->prioritized([
            MetadataKeyType::RICH_SCHEMA_PUBLISHED_TIME,
            MetadataKeyType::OG_ARTICLE_PUBLISHED_TIME
        ]);
    }


    public function modifiedTime(): ?DateTimeInterface
    {
        /** @var ?DateTimeInterface */
        return $this->prioritized([
            MetadataKeyType::RICH_SCHEMA_MODIFIED_TIME,
            MetadataKeyType::OG_ARTICLE_MODIFIED_TIME
        ]);
    }


    public function thumbnailUrl(): ?string
    {
        /** @var ?string */
        return $this->prioritized([
            MetadataKeyType::OG_IMAGE,
            MetadataKeyType::OG_IMAGE_URL,
            MetadataKeyType::OG_IMAGE_SECURE_URL,
            MetadataKeyType::TWITTER_IMAGE
        ]);
    }


    public function iconUrl(): ?string
    {
        /** @var ?string */
        return $this->prioritized([
            MetadataKeyType::FAVICON_URL
        ]);
    }


    public function locale(): ?string
    {
        /** @var ?string */
        return $this->prioritized([
            MetadataKeyType::LOCALE,
            MetadataKeyType::OG_LOCALE
        ]);
    }

}
