<?php

namespace Hyvor\Unfold;

use Hyvor\Unfold\Scraper\Metadata;
use Hyvor\Unfold\Scraper\MetadataParser;
use Hyvor\Unfold\Scraper\Scraper;
use Hyvor\Unfold\Types\UnfoldConfig;
use Hyvor\Unfold\Types\Unfolded;

class Unfold
{

    public static function unfold(string $url, UnfoldConfig $unfoldConfig): Unfolded
    {
        $startTime = microtime(true);
        $content = (new Scraper($url))->scrape();
        $metadata = (new MetadataParser($content))->parse();

        // TODO: embed

        return new Unfolded(
            $unfoldConfig->method,
            $url,

            null,
            Unfolded::title($metadata),
            Unfolded::description($metadata),
            Unfolded::authors($metadata),
            [],
            Unfolded::siteName($metadata),
            Unfolded::siteUrl($metadata),
            Unfolded::canonicalUrl($metadata),
            Unfolded::publishedTime($metadata),
            Unfolded::modifiedTime($metadata),
            Unfolded::thumbnailUrl($metadata),
            Unfolded::iconUrl($metadata),
            Unfolded::locale($metadata),
            (microtime(true) - $startTime) * 1000,
        );
    }
}