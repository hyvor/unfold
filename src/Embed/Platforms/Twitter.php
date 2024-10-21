<?php

namespace Hyvor\Unfold\Embed\Platforms;

use Hyvor\Unfold\Embed\EmbedParserAbstract;
use Hyvor\Unfold\Embed\EmbedParserOEmbedInterface;

class Twitter extends EmbedParserAbstract implements EmbedParserOEmbedInterface
{
    public function regex()
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
