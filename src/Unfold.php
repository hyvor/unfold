<?php

namespace Hyvor\Unfold;

use Hyvor\Unfold\Embed\Embed;
use Hyvor\Unfold\Objects\UnfoldedObject;
use Hyvor\Unfold\Link\Link;

class Unfold
{
    public static function unfold(
        string $url,
        UnfoldMethodEnum $method = UnfoldMethodEnum::LINK,
        UnfoldConfigObject $config = null,
    ): UnfoldedObject {
        $config ??= new UnfoldConfigObject();

        $startTime = microtime(true);

        if ($method === UnfoldMethodEnum::LINK) {
            return Link::getUnfoldedObject($url, $method, $config, $startTime);
        } elseif ($method === UnfoldMethodEnum::EMBED) {
            return Embed::getUnfoldedObject($url, $config);
        } else {
            // both
        }
    }
}
