<?php

namespace Hyvor\Unfold\Link\Metadata;

use DateTimeImmutable;
use DateTimeInterface;
use Exception;
use Hyvor\Unfold\Link\Metadata\Parsers\DescriptionParser;
use Hyvor\Unfold\Link\Metadata\Parsers\HtmlLangParser;
use Hyvor\Unfold\Link\Metadata\Parsers\JsonLdParser;
use Hyvor\Unfold\Link\Metadata\Parsers\LinkParser;
use Hyvor\Unfold\Link\Metadata\Parsers\MetadataKeyEnum;
use Hyvor\Unfold\Link\Metadata\Parsers\OgParser;
use Hyvor\Unfold\Link\Metadata\Parsers\TitleParser;
use Hyvor\Unfold\Link\Metadata\Parsers\TwitterParser;
use Hyvor\Unfold\Objects\MetadataObject;
use Hyvor\Unfold\Unfolded\UnfoldedAuthor;
use Hyvor\Unfold\Unfolded\UnfoldedTag;
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
                    $content = new UnfoldedAuthor(null, $content);
                } else {
                    $content = new UnfoldedAuthor($content, null);
                }
            }

            if ($keyType === MetadataKeyEnum::OG_ARTICLE_TAG) {
                $content = new UnfoldedTag($content);
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
