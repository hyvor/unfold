<?php

namespace Hyvor\Unfold;

use Hyvor\Unfold\MetadataParsers\MetadataParser;
use Hyvor\Unfold\Objects\UnfoldedObject;
use Hyvor\Unfold\Scraper\Scraper;

class Unfold
{
    public static function unfold(string $url, UnfoldConfigObject $unfoldConfig): UnfoldedObject
    {
        $startTime = microtime(true);
        $content = (new Scraper($url))->scrape();
        $metadata = (new MetadataParser($content))->parse();

        // TODO: embed

        return new UnfoldedObject(
            $unfoldConfig->method,
            $url,
            null,
            UnfoldedObject::title($metadata),
            UnfoldedObject::description($metadata),
            UnfoldedObject::authors($metadata),
            UnfoldedObject::tags($metadata),
            UnfoldedObject::siteName($metadata),
            UnfoldedObject::siteUrl($metadata),
            UnfoldedObject::canonicalUrl($metadata),
            UnfoldedObject::publishedTime($metadata),
            UnfoldedObject::modifiedTime($metadata),
            UnfoldedObject::thumbnailUrl($metadata),
            UnfoldedObject::iconUrl($metadata),
            UnfoldedObject::locale($metadata),
            (microtime(true) - $startTime) * 1000,
        );
    }
}
