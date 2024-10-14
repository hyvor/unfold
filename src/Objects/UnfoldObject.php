<?php

namespace Hyvor\Unfold\Objects;

use Hyvor\Unfold\Types\EmbedTypeEnum;

class UnfoldObject
{
    public string $version;
    public EmbedTypeEnum $type;
    public ?string $url;
    public ?string $html;
    public ?int $width;
    public ?int $height;
    public ?string $title;
    public ?string $author_name;
    public ?string $author_url;
    public ?string $provider_name;
    public ?string $provider_url;
    public ?int $cache_age;
    public ?int $thumbnail_width;
    public ?int $thumbnail_height;
    public ?string $thumbnail_url;

    public function __construct(array $data)
    {
        $this->version = '1.0';
        $this->type = EmbedTypeEnum::from($data['type']);

        if ($this->type === EmbedTypeEnum::PHOTO) {

            $this->url = $data['url'];
            $this->width = $data['width'];
            $this->height = $data['height'];

        } elseif ($this->type === EmbedTypeEnum::VIDEO || $this->type === EmbedTypeEnum::RICH) {

            $this->html = $data['html'];
            $this->width = $data['width'];
            $this->height = $data['height'];

        }

        if (isset($data['title'])) {
            $this->title = $data['title'];
        }

        if (isset($data['author_name'])) {
            $this->author_name = $data['author_name'];
        }

        if (isset($data['author_url'])) {
            $this->author_url = $data['author_url'];
        }

        if (isset($data['provider_name'])) {
            $this->provider_name = $data['provider_name'];
        }

        if (isset($data['provider_url'])) {
            $this->provider_url = $data['provider_url'];
        }

        if (isset($data['cache_age'])) {
            $this->cache_age = $data['cache_age'];
        }

        if (isset($data['thumbnail_url'])) {
            $this->thumbnail_url = $data['thumbnail_url'];
        }

        if (isset($data['thumbnail_width'])) {
            $this->thumbnail_width = $data['thumbnail_width'];
        }

        if (isset($data['thumbnail_height'])) {
            $this->thumbnail_height = $data['thumbnail_height'];
        }
    }
}