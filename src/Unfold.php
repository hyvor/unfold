<?php

namespace Hyvor\Unfold;

use Hyvor\Unfold\Embed\Embed;
use Hyvor\Unfold\Objects\UnfoldedObject;
use Hyvor\Unfold\Link\Link;
use Hyvor\Unfold\Objects\UnfoldRequestContextObject;

class Unfold
{

    /**
     * @throws UnfoldException
     */
    public static function unfold(
        string $url,
        UnfoldMethodEnum $method = UnfoldMethodEnum::LINK,
        UnfoldConfigObject $config = null,
    ): UnfoldedObject {
        $config ??= new UnfoldConfigObject();
        $context = new UnfoldRequestContextObject(
            $method,
            $config,
        );

        if ($method === UnfoldMethodEnum::LINK) {
            return Link::getUnfoldedObject($url, $context);
        } elseif ($method === UnfoldMethodEnum::EMBED) {
            return Embed::getUnfoldedObject($url, $context);
        } else {
            // both
        }
    }
}
