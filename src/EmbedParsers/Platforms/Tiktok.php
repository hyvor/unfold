<?php

namespace Hyvor\Unfold\EmbedParsers\Platforms;

use Hyvor\Unfold\EmbedParsers\EmbedParserAbstract;

class Tiktok extends EmbedParserAbstract
{
    public function regex()
    {
        return [
            "https://www.tiktok.com/.*",
            "https://www.tiktok.com/.*/video/.*" // the previous one already matches this?
        ];
    }

    public function oEmbedUrl(): ?string
    {
        return 'https://www.tiktok.com/oembed';
    }
}
