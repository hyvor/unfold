<?php

namespace Hyvor\Unfold\Embed\Platforms;

use Hyvor\Unfold\Embed\EmbedParserAbstract;
use Hyvor\Unfold\Embed\EmbedParserOEmbedInterface;

class Bluesky extends EmbedParserAbstract implements EmbedParserOEmbedInterface
{
    public function regex()
    {
        return [
            'https://bsky.app/profile/.*/post/.*'
        ];
    }

    public function oEmbedUrl(): string
    {
        return 'https://embed.bsky.app/oembed';
    }
}
