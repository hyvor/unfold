<?php

namespace Hyvor\Unfold\Embed\Parsers;

class Reddit extends Parser
{

    public function oEmbedRegex()
    {
        return [
            // oembed
            "https://reddit.com/r/.*/comments/.*/.*",
            "https://www.reddit.com/r/.*/comments/.*/.*",

            // custom
            "https://old.reddit.com/r/.*/comments/.*/.*", // added: 2024-10-19
        ];
    }

    public function oEmbedUrl(): ?string
    {
        return 'https://www.reddit.com/oembed';
    }
}