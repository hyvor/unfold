<?php

namespace Hyvor\Unfold\Link\MetadataParsers;

use DateTimeImmutable;
use DateTimeInterface;
use Exception;
use Hyvor\Unfold\Objects\AuthorObject;
use Hyvor\Unfold\Objects\MetadataObject;
use Hyvor\Unfold\Objects\TagObject;
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
            JsonLdParser::class,
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
    public function addMetadataFromMetaTags(array $keys): void
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

            if (
                $keyType === MetadataKeyEnum::OG_ARTICLE_PUBLISHED_TIME ||
                $keyType === MetadataKeyEnum::OG_ARTICLE_MODIFIED_TIME
            ) {
                $content = self::getDateTimeFromString($content);
            }

            if (
                $keyType === MetadataKeyEnum::OG_ARTICLE_AUTHOR ||
                $keyType === MetadataKeyEnum::TWITTER_CREATOR
            ) {
                if (str_contains($content, 'http://') || str_contains($content, 'https://')) {
                    $content = new AuthorObject(null, $content);
                } else {
                    $content = new AuthorObject($content, null);
                }
            }

            if ($keyType === MetadataKeyEnum::OG_ARTICLE_TAG) {
                $content = new TagObject($content);
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

    public static function getDateTimeFromString(?string $value): ?DateTimeInterface
    {
        if (!$value) {
            return null;
        }

        try {
            return new DateTimeImmutable($value);
        } catch (Exception) {
            return null;
        }
    }
}
