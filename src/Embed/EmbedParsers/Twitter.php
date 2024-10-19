<?php

namespace Hyvor\Unfold\Embed\EmbedParsers;

class Twitter extends EmbedParserAbstract
{

    public function oEmbedRegex()
    {
        return [
            "https://twitter.com/.*",
            "https://twitter.com/.*/status/.*",
            "https://.*.twitter.com/.*/status/.*",
            "https://x.com/.*",
            "https://x.com/.*/status/.*",
            "https://.*.x.com/.*/status/.*"
        ];
    }

    public function oEmbedUrl(): ?string
    {
        return 'https://publish.twitter.com/oembed';
    }
}