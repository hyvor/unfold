<?php

namespace Hyvor\Unfold\Unfolded;

use DateTimeInterface;
use Hyvor\Unfold\Link\Metadata\MetadataObject;
use Hyvor\Unfold\Link\Metadata\MetadataPriority;
use Hyvor\Unfold\UnfoldConfig;
use Psr\Http\Message\RequestInterface;

class UnfoldedLink
{
    public string $version = '1.0';

    /**
     * @param UnfoldedAuthor[] $authors
     * @param UnfoldedTag[] $tags
     */
    public function __construct(
        public string $url,
        public string $lastUrl,
        public ?string $title,
        public ?string $description,
        public ?string $siteName,
        public ?string $siteUrl,
        public ?string $canonicalUrl,
        public ?DateTimeInterface $publishedTime,
        public ?DateTimeInterface $modifiedTime,
        public ?string $thumbnailUrl,
        public ?string $iconUrl,
        public ?string $locale,
        public array $authors,
        public array $tags,
        public int $durationMs
    ) {
    }

    /**
     * @param MetadataObject[] $metadata
     */
    public static function fromMetadata(
        UnfoldConfig $config,
        array $metadata,
        ?RequestInterface $lastRequest,
    ): self {
        $metadataPriority = new MetadataPriority($metadata);

        $currentUrl = $config->url;
        if ($lastRequest && (string) $lastRequest->getUri() !== $currentUrl) {
            $currentUrl = (string) $lastRequest->getUri();
        }

        return new self(
            $config->url,
            $currentUrl,
            $metadataPriority->title(),
            $metadataPriority->description(),
            $metadataPriority->siteName(),
            $metadataPriority->siteUrl($currentUrl),
            $metadataPriority->canonicalUrl(),
            $metadataPriority->publishedTime(),
            $metadataPriority->modifiedTime(),
            $metadataPriority->thumbnailUrl(),
            $metadataPriority->iconUrl(),
            $metadataPriority->locale(),
            $metadataPriority->authors(),
            $metadataPriority->tags(),
            $config->duration()
        );
    }

}
