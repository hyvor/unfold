<?php

namespace Hyvor\Unfold\Embed\Platforms;

use Hyvor\Unfold\Embed\EmbedParserAbstract;
use Hyvor\Unfold\Embed\EmbedParserCustomInterface;
use Hyvor\Unfold\Embed\PlatformHelpers\FacebookHelper;

class FacebookVideo extends EmbedParserAbstract implements EmbedParserCustomInterface
{
    public const PRIORITY = 3;

    public function regex()
    {
        return [
            /**
             * The following regex are derived from the FacebookVideo oembed schema
             * "https://www.facebook.com/* /videos/*",
             * "https://www.facebook.com/video.php?id=*",
             * "https://www.facebook.com/video.php?v=*"
             */

            // with username
            'https?://(www|m|business)\.facebook\.com/([^/]+)/videos/([^/]+)',

            // video.php with id or v
            'https?://(www|m|business)\.facebook\.com/video\.php\?[^/]*(id|v)=([^&]+)',

            // watch with v
            'https?://(www|m|business)\.facebook\.com/watch/?\?[^/]*v=([^&]+)',

            // fb.watch
            'https?://fb\.watch/([^/]+)',

            // reel
            'https?://(www|m|business)\.facebook\.com/reel/([^/]+)',
        ];
    }

    public function getEmbedHtml(array $matches): string
    {
        $sdk = FacebookHelper::sdkScript();
        $url = $this->config->url;
        return <<<HTML
$sdk
<div class="fb-video" data-href="$url" data-width="500" data-show-text="true"></div>
HTML;
    }
}
