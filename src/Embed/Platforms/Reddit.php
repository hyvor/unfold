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
            "https://(?:(?:www|old)\.)?reddit.com/r/.*/comments/.*/.*",
        ];
    }

    public function oEmbedUrl(): string
    {
        return 'https://www.reddit.com/oembed';
    }
}
