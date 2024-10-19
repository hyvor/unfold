<?php

namespace Hyvor\Unfold\Scraper;

use Hyvor\Unfold\Scraper\MetadataParsers\OgParser;
use Hyvor\Unfold\Scraper\MetadataParsers\TwitterParser;
use Symfony\Component\DomCrawler\Crawler;

class MetadataParser
{
    // TODO: <title>
    // TODO: favicon
    // TODO: <link> canonical
    // TODO: <html lang>
    // TODO: Rich Schema

    /**
     * @var Metadata[]
     */
    private array $metadata = [];

    public Crawler $crawler;

    public Crawler $crawlerMeta;

    public function __construct(
        private string $content
    ) {
        $this->crawler = new Crawler($this->content);
        $this->crawlerMeta = $this->crawler->filterXPath('//meta');
    }

    /**
     * @return Metadata[]
     */
    public function parse(): array
    {

        $parsers = [
            OgParser::class,
            TwitterParser::class,
        ];

        $MetaTagKeys = [];

        foreach ($parsers as $parserClass) {
            $parser = new $parserClass($this);
            $parser->add();
            $MetaTagKeys = array_merge($MetaTagKeys, $parser->registerMetaTagsKeys());
        }

        $this->addMetadataFromMetaTags($MetaTagKeys);

        return $this->metadata;
    }

    /**
     * @param array<string, MetadataKey> $keys
     */
    public function addMetadataFromMetaTags(array $keys) : void
    {
        $metadata = [];

        $this->crawlerMeta->each(function (Crawler $node) use ($keys, &$metadata) {
            $name = $node->attr('name') ?? $node->attr('property');

            if (!$name) {
                return;
            }

            $keyType = $keys[$name] ?? null;

            if (!$keyType) {
                return;
            }

            $content = $node->attr('content');

            if (!$content) {
                return;
            }

            $metadata[] = new Metadata($keyType, $content);
        });

        $this->addMetadata($metadata);
    }

    /**
     * @param Metadata[] $metadata
     */
    public function addMetadata(array $metadata): void
    {
        $this->metadata = array_merge($this->metadata, $metadata);
    }
}