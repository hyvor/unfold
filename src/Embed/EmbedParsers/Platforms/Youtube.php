<?php

namespace Hyvor\Unfold\Embed\EmbedParsers\Platforms;

use Hyvor\Unfold\Embed\EmbedParsers\EmbedParserAbstract;
use Hyvor\Unfold\Embed\EmbedParsers\EmbedParserOEmbedInterface;

class Youtube extends EmbedParserAbstract implements EmbedParserOEmbedInterface
{
    public function regex()
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
