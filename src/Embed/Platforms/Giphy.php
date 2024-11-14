<?php

namespace Hyvor\Unfold\Embed\Platforms;

use Hyvor\Unfold\Embed\EmbedParserAbstract;
use Hyvor\Unfold\Embed\EmbedParserOEmbedInterface;

class Giphy extends EmbedParserAbstract implements EmbedParserOEmbedInterface
{
    public function regex()
    {
        return [
            /**
             * /gifs/ oembed returns a photo response
             * We return a simple <img> tag
             */
            "https://giphy.com/gifs/.*",

            /**
             * 2024-11-14: Clips oEmbed returns an iframe
             * but the iframe doesn't work due to X-Frame-Options: DENY
             */
            // "https://giphy.com/clips/.*",

            // 2024-11-14: gph.is links don't work with oembed
            // "http://gph.is/.*",

            "https://media\d?.giphy.com/media/.*/giphy.(gif|webp)",
        ];
    }

    public function oEmbedUrl(): string
    {
        return 'https://giphy.com/services/oembed';
    }

    protected function htmlFromOEmbedArray(array $data): ?string
    {
        $type = $data['type'] ?? null;

        /**
         * giphy.com/gifs/* return a photo oembed
         * so, we simply generate an <img> tag
         */
        if ($type === 'photo') {
            /** @var ?string $url */
            $url = $data['url'] ?? null;

            if (!$url) {
                return null;
            }

            /** @var ?string $title */
            $title = $data['title'] ?? '';

            $width = $data['width'] ?? null;
            // $height = $data['height'] ?? null;

            $attrs = [
                'src' => $url,
                'alt' => strval($title),
                'width' => is_int($width) ? min($width, 600) : null,
                //'height' => is_int($height) ? min($height, 600) : null,
                'style' => 'max-width: 100%;'
            ];
            $attrs = array_filter($attrs);
            $attrs = array_map(fn($key, $value) => "$key=\"$value\"", array_keys($attrs), $attrs);

            return "<img " . implode(' ', $attrs) . ">";
        }

        /** @var ?string $html */
        $html = $data['html'] ?? null;

        return $html;
    }
}
