<?php

namespace Hyvor\Unfold\Scraper;

use Symfony\Component\DomCrawler\Crawler;

class MetadataParser
{
    /**
     * @var Metadata[]
     */
    private array $metadata = [];

    public function __construct(
        private string $content
    ) {}

    /**
     * @return Metadata[]
     */
    public function parse(): array
    {

        $crawler = new Crawler($this->content);

        $crawler->filterXPath('//meta')->each(function (Crawler $node) {
            $meta = [
                'description' => MetadataKey::DESCRIPTION,
                'robots' => MetadataKey::ROBOTS,

                'og:title' => MetadataKey::OG_TITLE,
                'og:type' => MetadataKey::OG_TYPE,
                'og:image' => MetadataKey::OG_IMAGE,
                'og:url' => MetadataKey::OG_URL,

                'og:audio' => MetadataKey::OG_AUDIO,
                'og:description' => MetadataKey::OG_DESCRIPTION,
                'og:locale' => MetadataKey::OG_LOCALE,
                'og:locale:alternate' => MetadataKey::OG_LOCALE_ALTERNATE,
                'og:site_name' => MetadataKey::OG_SITE_NAME,
                'og:video' => MetadataKey::OG_VIDEO,

                'og:image:url' => MetadataKey::OG_IMAGE_URL,
                'og:image:secure_url' => MetadataKey::OG_IMAGE_SECURE_URL,
                'og:image:type' => MetadataKey::OG_IMAGE_TYPE,

                'og:video:secure_url' => MetadataKey::OG_VIDEO_SECURE_URL,
                'og:video:type' => MetadataKey::OG_VIDEO_TYPE,

                'og:audio:secure_url' => MetadataKey::OG_AUDIO_SECURE_URL,
                'og:audio:type' => MetadataKey::OG_AUDIO_TYPE,

                'og:article:published_time' => MetadataKey::OG_ARTICLE_PUBLISHED_TIME,
                'og:article:modified_time' => MetadataKey::OG_ARTICLE_MODIFIED_TIME,
                'og:article:author' => MetadataKey::OG_ARTICLE_AUTHOR,
                'og:article:tag' => MetadataKey::OG_ARTICLE_TAG,

                'twitter:card' => MetadataKey::TWITTER_CARD,
                'twitter:site' => MetadataKey::TWITTER_SITE,
                'twitter:creator' => MetadataKey::TWITTER_CREATOR,
                'twitter:description' => MetadataKey::TWITTER_DESCRIPTION,
                'twitter:title' => MetadataKey::TWITTER_TITLE,
                'twitter:image' => MetadataKey::TWITTER_IMAGE,


                // add other tags here
            ];

            $name = $node->attr('name') ?? $node->attr('property');

            if (!$name) {
                return;
            }

            $keyType = $meta[$name] ?? null;

            if (!$keyType) {
                return;
            }

            $content = $node->attr('content');

            if (!$content) {
                return;
            }

            $this->metadata[] = new Metadata($keyType, $content);


        });

        return $this->metadata;
        // <title>
        // <link> canonical
    }
}