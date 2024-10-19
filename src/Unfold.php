<?php

namespace Hyvor\Unfold;

use Hyvor\Unfold\Objects\UnfoldObject;
use Hyvor\Unfold\Oembed\Oembed;
use Hyvor\Unfold\Scraper\Metadata;
use Hyvor\Unfold\Scraper\MetadataParser;
use Hyvor\Unfold\Scraper\Scraper;
use Hyvor\Unfold\Types\UnfoldConfig;
use Hyvor\Unfold\Types\Unfolded;

class Unfold
{

    public static function unfold(string $url): UnfoldObject
    {

        $content = (new Scraper($url))->scrape();
        $metadata = (new MetadataParser($content))->parse();

        // todo: embed

        return new Unfolded($metadata);

    }
}