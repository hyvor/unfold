<?php

namespace Hyvor\Unfold\Embed\Platforms;

use Hyvor\Unfold\Embed\EmbedParserAbstract;
use Hyvor\Unfold\Embed\EmbedParserCustomInterface;

class Tiktok extends EmbedParserAbstract implements EmbedParserCustomInterface
{
    public function regex()
    {
        return [
            // "https://www.tiktok.com/.*",
            "https://www.tiktok.com/.*/video/(\d+)"
        ];
    }

    public function getEmbedHtml(array $matches): string
    {
        $url = $this->config->url;
        $id = $matches[1] ?? '';

        /**
         * - the embed is identified by data-video-id
         * - data
         */

        return <<<HTML
<blockquote class="tiktok-embed" cite="$url" data-video-id="$id" style="max-width: 605px;min-width: 325px;" ><section><a href="$url" target="_blank">$url</a></section> </blockquote> <script async src="https://www.tiktok.com/embed.js"></script>
HTML;
    }
}
