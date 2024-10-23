<?php

namespace Hyvor\Unfold\Embed\Iframe;

class PrivacyIframe
{
    public static function wrap(string $html): string
    {
        $childJs = (string) file_get_contents(__DIR__ . '/child.js');

        return <<<HTML
<html>
<body style="margin:0;overflow:hidden">
$html
$childJs
</body>
</html>
HTML;
    }

}
