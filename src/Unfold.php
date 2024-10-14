<?php

namespace Hyvor\Unfold;

use Hyvor\Unfold\Objects\UnfoldObject;
use Hyvor\Unfold\Oembed\Oembed;

class Unfold
{
    public static function unfold(string $url): UnfoldObject
    {
        // Check if oEmbed supported
        $endpoint = Oembed::checkOembedSupport($url);

        if ($endpoint !== null) {
            // Call oEmbed endpoint
            $data = Oembed::getEmbedData($endpoint, $url);
        }
        else {
            // TODO
            // Unfold endpoint
            $data = [];
        }

         return new UnfoldObject($data);
    }
}