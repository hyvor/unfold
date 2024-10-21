<?php

namespace Hyvor\Unfold\Embed;

class OEmbedResponse
{
    public function __construct(
        public string $version,
        public OEmbedTypeEnum $type,

        // only in photo and video types
        public ?string $url,

        // only set in video, rich types
        public ?string $html,

        // only in photo, video, and rich types
        public ?int $width,
        public ?int $height,

        // title
        public ?string $title,

        // author
        public ?string $author_name,
        public ?string $author_url,

        // provider
        public ?string $provider_name,
        public ?string $provider_url,

        // thumbnail
        public ?string $thumbnail_url,
        public ?int $thumbnail_width,
        public ?int $thumbnail_height
    ) {
    }


    /**
     * @param array<string, string | int | null> $array
     */
    public static function fromArray(array $array): OEmbedResponse
    {
        return new OEmbedResponse(
            (string)($array['version'] ?? '1.0'),
            OEmbedTypeEnum::tryFrom($array['type'] ?? 'link') ?? OEmbedTypeEnum::LINK,
            array_key_exists('url', $array) ? (string)$array['url'] : null,
            array_key_exists('html', $array) ? (string)$array['html'] : null,
            array_key_exists('width', $array) ? (int)$array['width'] : null,
            array_key_exists('height', $array) ? (int)$array['height'] : null,
            array_key_exists('title', $array) ? (string)$array['title'] : null,
            array_key_exists('author_name', $array) ? (string)$array['author_name'] : null,
            array_key_exists('author_url', $array) ? (string)$array['author_url'] : null,
            array_key_exists('provider_name', $array) ? (string)$array['provider_name'] : null,
            array_key_exists('provider_url', $array) ? (string)$array['provider_url'] : null,
            array_key_exists('thumbnail_url', $array) ? (string)$array['thumbnail_url'] : null,
            array_key_exists('thumbnail_width', $array) ? (int)$array['thumbnail_width'] : null,
            array_key_exists('thumbnail_height', $array) ? (int)$array['thumbnail_height'] : null
        );
    }


}
