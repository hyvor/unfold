<?php

namespace Hyvor\Unfold\Embed\Iframe;

class PrivacyIframe
{
    public static function wrap(string $html): string
    {
        $encoded = base64_encode($html);

        return <<<HTML
<iframe src="/endpoint?data=$encoded"/>

<iframe src="/media/embed?url=$url" />
HTML;
    }

}

class EmbedController
{
    public function handle()
    {
        $url = $_GET['url'];
        $embed = Unfold::unfold($url, EMBED);
        echo $embed;
    }
}
