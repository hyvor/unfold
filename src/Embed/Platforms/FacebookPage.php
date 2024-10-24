<?php

namespace Hyvor\Unfold\Embed\Platforms;

use Hyvor\Unfold\Embed\EmbedParserAbstract;
use Hyvor\Unfold\Embed\EmbedParserCustomInterface;
use Hyvor\Unfold\Embed\PlatformHelpers\FacebookHelper;

class FacebookPage extends EmbedParserAbstract implements EmbedParserCustomInterface
{
    public const PRIORITY = 1;

    public function regex()
    {
        return [
            /**
             * Pages have URLs like: facebook.com/MyPage
             * They can also be: facebook.com/MyPage/about
             */
            'https?://(www|web|m).facebook.com/[^/]+/?(about|photos|videos|events|timeline|photos_stream)?/?(\?[^/]+)?$',
        ];
    }

    public function getEmbedHtml(array $matches): string
    {
        $url = $this->config->url;

        $name = explode('/', $url)[3] ?? '';
        $sdk = FacebookHelper::sdkScript();

        return <<<HTML
$sdk
<div class="fb-page" data-href="$url" data-tabs="timeline" data-width="500" data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="$url" class="fb-xfbml-parse-ignore"><a href="$url">$name</a></blockquote></div>
HTML;
    }
}
