<?php

namespace Hyvor\Unfold\MetadataParsers;

use Hyvor\Unfold\Objects\MetadataObject;
use Symfony\Component\DomCrawler\Crawler;

class MetadataParser
{
    // TODO: Rich Schema

    /**
     * @var MetadataObject[]
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
     * @return MetadataObject[]
     */
    public function parse(): array
    {
        $parsers = [
            HtmlLangParser::class,
            TitleParser::class,
            DescriptionParser::class,
            LinkParser::class,
            OgParser::class,
            TwitterParser::class,
        ];

        $metaTagKeys = [];

        foreach ($parsers as $parserClass) {
            $parser = new $parserClass($this);
            $parser->add();
            $metaTagKeys = array_merge($metaTagKeys, $parser->registerMetaTagsKeys());
        }

        $this->addMetadataFromMetaTags($metaTagKeys);

        return $this->metadata;
    }

    /**
     * @param array<string, MetadataKeyEnum> $keys
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

            $metadata[] = new MetadataObject($keyType, $content);
        });

        $this->addMetadata($metadata);
    }

    /**
     * @param MetadataObject[]|MetadataObject $metadata
     */
    public function addMetadata(array|MetadataObject $metadata): void
    {
        if (!is_array($metadata)) {
            $metadata = [$metadata];
        }
        $this->metadata = array_merge($this->metadata, $metadata);
    }
}