<?php

namespace Hyvor\Unfold\Types;

use DateTimeInterface;
class Unfolded
{
    /**
     * @param Author[] $authors
     * @param Tag[] $tags
     */
    public function __construct(
        public string  $version,
        public Method  $method,
        public string $url,

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
    }
}