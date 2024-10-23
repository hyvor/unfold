<?php

namespace Hyvor\Unfold\Embed\PlatformHelpers;

class FacebookHelper
{
    public static function sdkScript(): string
    {
        return <<<HTML
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v21.0"></script>
HTML;
    }

}
