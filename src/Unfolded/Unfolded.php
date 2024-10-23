<?php

namespace Hyvor\Unfold\Unfolded;

use DateTimeInterface;
use Hyvor\Unfold\Embed\EmbedResponseObject;
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
            $metadataPriority->siteUrl($url),
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
