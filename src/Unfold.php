<?php

namespace Hyvor\Unfold;

use Hyvor\Unfold\Embed\Embed;
use Hyvor\Unfold\Link\Link;
use Hyvor\Unfold\Objects\UnfoldRequestContextObject;
use Hyvor\Unfold\Unfolded\Unfolded;

class Unfold
{

    /**
     * @throws UnfoldException
     */
    public static function unfold(
        string $url,
        UnfoldMethod $method = UnfoldMethod::LINK,
        UnfoldConfigObject $config = null,
    ): Unfolded {
        $config ??= new UnfoldConfigObject();
        $context = new UnfoldRequestContextObject(
            $method,
            $config,
        );

        if ($method === UnfoldMethod::LINK) {
            return Link::getUnfoldedObject($url, $context);
        } elseif ($method === UnfoldMethod::EMBED) {
            return Embed::getUnfoldedObject($url, $context);
        } else {
            // both
        }
    }
}
