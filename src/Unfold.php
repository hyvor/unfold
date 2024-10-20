<?php

namespace Hyvor\Unfold;

use Hyvor\Unfold\MetadataParsers\MetadataParser;
use Hyvor\Unfold\Objects\UnfoldedObject;
use Hyvor\Unfold\Scraper\Scraper;

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
            return Scraper::getUnfoldedObject($url, $method, $config, $startTime);
        } elseif ($method === UnfoldMethodEnum::EMBED) {
            //
        } else {
            // both
        }
    }
}