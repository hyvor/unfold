<?php

namespace Hyvor\Unfold\Scraper;

use Hyvor\Unfold\Scraper\MetadataParsers\OgParser;
use Hyvor\Unfold\Scraper\MetadataParsers\TwitterParser;
use Symfony\Component\DomCrawler\Crawler;

class MetadataParser
{
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

        foreach ($parsers as $parserClass) {
            $parser = new $parserClass($this);
            $parser->add();
        }

        return $this->metadata;

//        $crawler->filterXPath('//meta')->each(function (Crawler $node) {
//            $meta = [
//                'description' => MetadataKey::DESCRIPTION,
//
//                'og:title' => MetadataKey::OG_TITLE,
//                'og:type' => MetadataKey::OG_TYPE,
//                'og:image' => MetadataKey::OG_IMAGE,
//                'og:url' => MetadataKey::OG_URL,
//
//                'og:audio' => MetadataKey::OG_AUDIO,
//                'og:description' => MetadataKey::OG_DESCRIPTION,
//                'og:locale' => MetadataKey::OG_LOCALE,
//                'og:site_name' => MetadataKey::OG_SITE_NAME,
//                'og:video' => MetadataKey::OG_VIDEO,
//
//                'og:image:url' => MetadataKey::OG_IMAGE_URL,
//                'og:image:secure_url' => MetadataKey::OG_IMAGE_SECURE_URL,
//                'og:image:type' => MetadataKey::OG_IMAGE_TYPE,
//
//                'og:video:secure_url' => MetadataKey::OG_VIDEO_SECURE_URL,
//                'og:video:type' => MetadataKey::OG_VIDEO_TYPE,
//
//                'og:audio:secure_url' => MetadataKey::OG_AUDIO_SECURE_URL,
//                'og:audio:type' => MetadataKey::OG_AUDIO_TYPE,
//
//                'og:article:published_time' => MetadataKey::OG_ARTICLE_PUBLISHED_TIME,
//                'og:article:modified_time' => MetadataKey::OG_ARTICLE_MODIFIED_TIME,
//                'og:article:author' => MetadataKey::OG_ARTICLE_AUTHOR,
//                'og:article:tag' => MetadataKey::OG_ARTICLE_TAG,
//
//                'twitter:card' => MetadataKey::TWITTER_CARD,
//                'twitter:site' => MetadataKey::TWITTER_SITE,
//                'twitter:creator' => MetadataKey::TWITTER_CREATOR,
//                'twitter:description' => MetadataKey::TWITTER_DESCRIPTION,
//                'twitter:title' => MetadataKey::TWITTER_TITLE,
//                'twitter:image' => MetadataKey::TWITTER_IMAGE,
//
//
//                // add other tags here
//            ];
//
//            $name = $node->attr('name') ?? $node->attr('property');
//
//            if (!$name) {
//                return;
//            }
//
//            $keyType = $meta[$name] ?? null;
//
//            if (!$keyType) {
//                return;
//            }
//
//            $content = $node->attr('content');
//
//            if (!$content) {
//                return;
//            }
//
//            $this->metadata[] = new Metadata($keyType, $content);
//
//
//        });

        // TODO: <title>
        // TODO: favicon
        // TODO: <link> canonical
        // TODO: <html lang>
        // TODO: Rich Schema
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