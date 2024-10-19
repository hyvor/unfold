<?php

namespace Hyvor\Unfold\Embed\EmbedParsers;

class Youtube extends EmbedParserAbstract
{
    public function oEmbedRegex()
    {
        return [
            "https://.*.youtube.com/watch.*",
            "https://.*.youtube.com/v/.*",
            "https://youtu.be/.*",
            "https://.*.youtube.com/playlist\?list=.*",
            "https://youtube.com/playlist\?list=.*",
            "https://.*.youtube.com/shorts.*",
            "https://youtube.com/shorts.*",
            "https://.*.youtube.com/embed/.*",
            "https://.*.youtube.com/live.*",
            "https://youtube.com/live.*"
        ];
    }

    public function oEmbedUrl(): ?string
    {
        return 'https://www.youtube.com/oembed';
    }
}
