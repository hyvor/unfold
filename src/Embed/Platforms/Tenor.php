<?php

namespace Hyvor\Unfold\Embed\Platforms;

use Hyvor\Unfold\Embed\EmbedParserAbstract;
use Hyvor\Unfold\Embed\EmbedParserOEmbedInterface;

class Tenor extends EmbedParserAbstract implements EmbedParserOEmbedInterface
{
    public function regex()
    {
        return [
            'https://tenor.com/view/(.*)',
        ];
    }

    public function oEmbedUrl(): string
    {
        return 'https://tenor.com/oembed';
    }
}
