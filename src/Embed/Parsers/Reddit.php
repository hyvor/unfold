<?php

namespace Hyvor\Unfold\Embed\Parsers;

class Reddit extends Parser
{

    public function regex()
    {
        return [
            // oembed
            "https://reddit.com/r/.*/comments/.*/.*",
            "https://www.reddit.com/r/.*/comments/.*/.*",

            // custom
            // ''
        ];
    }

    public function oEmbedUrl(): ?string
    {
        return 'https://www.reddit.com/oembed';
    }
}