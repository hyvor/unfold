<?php

namespace Hyvor\Unfold\Embed\Platforms;

use Hyvor\Unfold\Embed\EmbedParserAbstract;
use Hyvor\Unfold\Embed\EmbedParserCustomInterface;

class Reddit extends EmbedParserAbstract implements EmbedParserCustomInterface
{
    public function regex()
    {
        return [
            // post
            "https://(?:(?:www|old|embed)\.)?reddit.com/(?P<path>r/.*/comments/.*/.*)",

            // subreddit
            'https://(?:(?:www|old|embed)\.)?reddit.com/r/(?P<path>[a-zA-Z0-9_-]+)/?',
        ];
    }

    public function getEmbedHtml(array $matches): string
    {
        $url = $this->config->url;

        return <<<HTML
<blockquote class="reddit-embed-bq"><a href="$url"></a></blockquote><script async="" src="https://embed.reddit.com/widgets.js" charset="UTF-8"></script>
HTML;
    }

    public function oEmbedUrl(): string
    {
        return 'https://www.reddit.com/oembed';
    }
}
