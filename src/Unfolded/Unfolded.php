<?php

namespace Hyvor\Unfold\Unfolded;

use DateTimeInterface;
use Hyvor\Unfold\Embed\EmbedResponseObject;
use Hyvor\Unfold\Link\Metadata\MetadataObject;
use Hyvor\Unfold\Link\Metadata\MetadataPriority;
use Hyvor\Unfold\UnfoldConfig;
use Hyvor\Unfold\UnfoldMethod;
use Psr\Http\Message\RequestInterface;

class Unfolded
{
    public string $version;

    /**
     * @param UnfoldedAuthor[] $authors
     * @param UnfoldedTag[] $tags
     */
    public function __construct(
        public UnfoldMethod $method,
        public string $originalUrl,
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
    public static function fromMetadata(
        UnfoldConfig $config,
        array $metadata,
        ?RequestInterface $lastRequest,
    ): self {
        $metadataPriority = new MetadataPriority($metadata);

        $currentUrl = $config->url;
        if ($lastRequest && (string)$lastRequest->getUri() !== $currentUrl) {
            $currentUrl = (string)$lastRequest->getUri();
        }

        return new self(
            $config->method,
            $config->url,
            $currentUrl,
            null,
            $metadataPriority->title(),
            $metadataPriority->description(),
            $metadataPriority->authors(),
            $metadataPriority->tags(),
            $metadataPriority->siteName(),
            $metadataPriority->siteUrl($currentUrl),
            $metadataPriority->canonicalUrl(),
            $metadataPriority->publishedTime(),
            $metadataPriority->modifiedTime(),
            $metadataPriority->thumbnailUrl(),
            $metadataPriority->iconUrl(),
            $metadataPriority->locale(),
            $config->duration()
        );
    }

    public static function fromEmbed(
        EmbedResponseObject $embed,
        UnfoldConfig $config,
    ): self {
        $authors = $embed->author_url || $embed->author_name ?
            [new UnfoldedAuthor($embed->author_name, $embed->author_url)] : [];

        return new self(
            $config->method,
            $config->url,
            $config->url,
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
            $config->duration()
        );
    }

}
