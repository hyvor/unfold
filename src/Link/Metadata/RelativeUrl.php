<?php

namespace Hyvor\Unfold\Link\Metadata;

use League\Uri\Uri;

class RelativeUrl
{
    /**
     * Resolves absolute URL from relative URL
     */
    public static function resolve(string $url, string $baseUrl): string
    {
        $parsedUrl = parse_url($url);
        if (isset($parsedUrl['host'])) {
            return $url;
        } else {
            return Uri::fromBaseUri($url, $baseUrl)->toString();
        }
    }

}
