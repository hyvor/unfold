<?php

namespace Hyvor\Unfold\Embed\Platforms;

use Hyvor\Unfold\Embed\EmbedParserAbstract;
use Hyvor\Unfold\Embed\EmbedParserOEmbedInterface;

class Tiktok extends EmbedParserAbstract implements EmbedParserOEmbedInterface
{
    public function regex()
    {
        return [
            "https://www.tiktok.com/.*",
            "https://www.tiktok.com/.*/video/.*" // the previous one already matches this?
        ];
    }

    public function oEmbedUrl(): string
    {
        return 'https://www.tiktok.com/oembed';
    }
}
