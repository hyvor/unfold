<?php

namespace Hyvor\Unfold\Embed\EmbedParsers;

class Tiktok extends EmbedParserAbstract
{

    public function oEmbedRegex()
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