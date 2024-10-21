<?php

namespace Hyvor\Unfold\Embed\Platforms;

use Hyvor\Unfold\Embed\EmbedParserAbstract;
use Hyvor\Unfold\Embed\EmbedParserOEmbedInterface;

class Reddit extends EmbedParserAbstract implements EmbedParserOEmbedInterface
{
    public function regex()
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
