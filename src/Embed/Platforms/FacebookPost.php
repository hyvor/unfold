<?php

namespace Hyvor\Unfold\Embed\Platforms;

use Hyvor\Unfold\Embed\EmbedParserAbstract;
use Hyvor\Unfold\Embed\EmbedParserCustomInterface;
use Hyvor\Unfold\Embed\PlatformHelpers\FacebookHelper;

class FacebookPost extends EmbedParserAbstract implements EmbedParserCustomInterface
{
    public const PRIORITY = 2;

    public function regex()
    {
        return [
            /**
             * The following regex are derived from the FacebookPost oembed schema
             * "https://www.facebook.com/* /posts/*",
             * "https://www.facebook.com/* /activity/*",
             * "https://www.facebook.com/* /photos/*",
             * "https://www.facebook.com/photo.php?fbid=*",
             * ~~"https://www.facebook.com/photos/*",~~
             * "https://www.facebook.com/permalink.php?story_fbid=*",
             * "https://www.facebook.com/media/set?set=*",
             * ~~"https://www.facebook.com/questions/*",~~
             * ~~"https://www.facebook.com/notes/* / * /*"~~
             */

            // with username
            'https?://(?:www|m|business)\.facebook\.com/(?:[^/]+)/(?:posts|activity|photos)/(?:[^/]+)',
            // photo.php
            'https?://(?:www|m|business)\.facebook\.com/photo\.php\?[^/]*fbid=(?:\d+)',
            // permalink.php and story.php
            'https?://(?:www|m|business)\.facebook\.com/(permalink|story)\.php\?[^/]*story_fbid=.*',
            // media set
            'https?://(?:www|m|business)\.facebook\.com/media/set/\?set=.*',
        ];
    }

    public function getEmbedHtml(array $matches): string
    {
        $url = $this->url;
        $sdk = FacebookHelper::sdkScript();

        return <<<HTML
$sdk
<div class="fb-post" data-href="$url" data-width="500" data-show-text="true"></div>
HTML;
    }
}
