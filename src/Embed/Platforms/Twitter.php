<?php

namespace Hyvor\Unfold\Embed\Platforms;

use Hyvor\Unfold\Embed\EmbedParserAbstract;
use Hyvor\Unfold\Embed\EmbedParserCustomInterface;

class Twitter extends EmbedParserAbstract implements EmbedParserCustomInterface
{
    public function regex()
    {
        return [
            "https://(?:.*\.)?twitter.com/(.*/status/.*)",
            "https://(?:.*\.)?x.com/(.*/status/.*)"
        ];
    }

    public function getEmbedHtml(array $matches): string
    {
        $path = $matches[1] ?? '';
        $url = 'https://twitter.com/' . $path;

        return <<<HTML
<blockquote class="twitter-tweet" data-dnt="true"><a href="$url">$url</a></blockquote><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
HTML;
    }
}
