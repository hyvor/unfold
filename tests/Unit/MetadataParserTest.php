<?php

namespace Hyvor\Unfold\Tests\Unit;

use Hyvor\Unfold\MetadataParsers\MetadataKeyEnum;
use Hyvor\Unfold\MetadataParsers\MetadataParser;
use Hyvor\Unfold\Objects\AuthorObject;
use Hyvor\Unfold\Objects\MetadataObject;
use DateTimeInterface;
use DateTimeImmutable;
use Hyvor\Unfold\Objects\TagObject;

dataset('contents', [
    'all valid og and twitter tags' => ['<html><head>
        <meta property="og:title" content="Nadil Karunarathna" />
        <meta property="og:type" content="website" />
        <meta property="og:image" content="https://nadil.io/image.jpg" />
        <meta property="og:url" content="https://nadil.io" />
        
        <meta property="og:audio" content="https://nadil.io/audio.mp3" />
        <meta property="og:description" content="Personal Blog" />
        <meta property="og:locale" content="en_US" />
        <meta property="og:locale:alternate" content="fr_FR" />
        <meta property="og:locale:alternate" content="si_LK" />
        <meta property="og:site_name" content="Nadil Karunarathna" />
        <meta property="og:video" content="https://nadil.io/video.mp4" />
        
        <meta property="og:image:url" content="https://nadil.io/image.jpg" />
        <meta property="og:image:secure_url" content="https://nadil.io/image.jpg" />
        <meta property="og:image:type" content="image/jpeg" />
        
        <meta property="og:video:secure_url" content="https://nadil.io/video.mp4" />
        <meta property="og:video:type" content="video/mp4" />
        
        <meta property="og:audio:secure_url" content="https://nadil.io/audio.mp3" />
        <meta property="og:audio:type" content="audio/mpeg" />
        
        <meta property="article:published_time" content="2021-10-10T10:10:10Z" />
        <meta property="article:modified_time" content="2021-10-10T10:10:10Z" />
        <meta property="article:author" content="Nadil Karunarathna" />
        <meta property="article:author" content="Supun Wimalasena" />
        <meta property="article:tag" content="HYVOR" />
        <meta property="article:author" content="Supun Wimalasena" />
        <meta property="article:tag" content="HYVOR" />
        <meta property="article:tag" content="PHP" />
        <meta property="article:tag" content="OEmbed" />
        <meta property="article:tag" content="OEmbed" />
        
        <meta name="twitter:card" content="summary" />
        <meta name="twitter:site" content="@nadil_k" />
        <meta name="twitter:creator" content="@nadil_k" />
        <meta name="twitter:description" content="Personal Blog" />
        <meta name="twitter:title" content="Nadil Karunarathna" />
        <meta name="twitter:image" content="https://nadil.io/image.jpg" />        
      </head></html>', [
        new MetadataObject(MetadataKeyEnum::OG_TITLE, 'Nadil Karunarathna'),
        new MetadataObject(MetadataKeyEnum::OG_TYPE, 'website'),
        new MetadataObject(MetadataKeyEnum::OG_IMAGE, 'https://nadil.io/image.jpg'),
        new MetadataObject(MetadataKeyEnum::OG_URL, 'https://nadil.io'),

        new MetadataObject(MetadataKeyEnum::OG_AUDIO, 'https://nadil.io/audio.mp3'),
        new MetadataObject(MetadataKeyEnum::OG_DESCRIPTION, 'Personal Blog'),
        new MetadataObject(MetadataKeyEnum::OG_LOCALE, 'en_US'),
        new MetadataObject(MetadataKeyEnum::OG_SITE_NAME, 'Nadil Karunarathna'),
        new MetadataObject(MetadataKeyEnum::OG_VIDEO, 'https://nadil.io/video.mp4'),

        new MetadataObject(MetadataKeyEnum::OG_IMAGE_URL, 'https://nadil.io/image.jpg'),
        new MetadataObject(MetadataKeyEnum::OG_IMAGE_SECURE_URL, 'https://nadil.io/image.jpg'),
        new MetadataObject(MetadataKeyEnum::OG_IMAGE_TYPE, 'image/jpeg'),

        new MetadataObject(MetadataKeyEnum::OG_VIDEO_SECURE_URL, 'https://nadil.io/video.mp4'),
        new MetadataObject(MetadataKeyEnum::OG_VIDEO_TYPE, 'video/mp4'),

        new MetadataObject(MetadataKeyEnum::OG_AUDIO_SECURE_URL, 'https://nadil.io/audio.mp3'),
        new MetadataObject(MetadataKeyEnum::OG_AUDIO_TYPE, 'audio/mpeg'),

        new MetadataObject(MetadataKeyEnum::OG_ARTICLE_PUBLISHED_TIME, new DateTimeImmutable('2021-10-10T10:10:10Z')),
        new MetadataObject(MetadataKeyEnum::OG_ARTICLE_MODIFIED_TIME, new DateTimeImmutable('2021-10-10T10:10:10Z')),
        new MetadataObject(MetadataKeyEnum::OG_ARTICLE_AUTHOR, new AuthorObject('Nadil Karunarathna', null)),
        new MetadataObject(MetadataKeyEnum::OG_ARTICLE_AUTHOR, new AuthorObject('Supun Wimalasena', null)),
        new MetadataObject(MetadataKeyEnum::OG_ARTICLE_TAG, new TagObject('HYVOR')),
        new MetadataObject(MetadataKeyEnum::OG_ARTICLE_TAG, new TagObject('PHP')),
        new MetadataObject(MetadataKeyEnum::OG_ARTICLE_TAG, new TagObject('OEmbed')),

        new MetadataObject(MetadataKeyEnum::TWITTER_CARD, 'summary'),
        new MetadataObject(MetadataKeyEnum::TWITTER_SITE, '@nadil_k'),
        new MetadataObject(MetadataKeyEnum::TWITTER_CREATOR, new AuthorObject('@nadil_k', null)),
        new MetadataObject(MetadataKeyEnum::TWITTER_DESCRIPTION, 'Personal Blog'),
        new MetadataObject(MetadataKeyEnum::TWITTER_TITLE, 'Nadil Karunarathna'),
        new MetadataObject(MetadataKeyEnum::TWITTER_IMAGE, 'https://nadil.io/image.jpg'),
    ]],

    'no metadata' => ['<html><head></head><body></body></html>', []],
    'og tag in the body' => [
        '<html><head></head><body><meta property="og:title" content="Nadil Karunarathna" /></body></html>',
        [
            new MetadataObject(MetadataKeyEnum::OG_TITLE, 'Nadil Karunarathna')
        ]
    ],
    'no content' => [
        '<html><head><meta property="og:title" /></head><body></body></html>',
        []
    ],
    'unclosed meta tag' => [
        '<html><head><meta property="og:title" content="Nadil Karunarathna"></head><body></body></html>',
        [
            new MetadataObject(MetadataKeyEnum::OG_TITLE, 'Nadil Karunarathna')
        ]
    ],
    'no name or property' => [
        '<html><head><meta content="Nadil Karunarathna" /></head><body></body></html>',
        []
    ],
    'non ascii content' => [
        '<meta property="og:title" content="නදිල් කරුණාරත්න" />',
        [new MetadataObject(MetadataKeyEnum::OG_TITLE, 'නදිල් කරුණාරත්න')]
    ],
    'non ascii 2' => [
        '<meta property="og:title" content="Nas manhãs de domingo" />',
        [
            new MetadataObject(MetadataKeyEnum::OG_TITLE, 'Nas manhãs de domingo')
        ]
    ],
    'without html tags' => [
        '<meta property="og:title" content="Nadil Karunarathna" />',
        [
            new MetadataObject(MetadataKeyEnum::OG_TITLE, 'Nadil Karunarathna')
        ]
    ],
    'title tag' => [
        '<title>Nadil Karunarathna</title>',
        [
            new MetadataObject(MetadataKeyEnum::TITLE, 'Nadil Karunarathna')
        ]
    ],
    'meta description' => [
        '<meta name="description" content="Personal Blog" />',
        [
            new MetadataObject(MetadataKeyEnum::DESCRIPTION, 'Personal Blog')
        ]
    ],
    'link tags' => [
        '<link rel="canonical" href="https://nadil.io" />
         <link rel="icon" href="https://nadil.io/favicon.ico" />',
        [
            new MetadataObject(MetadataKeyEnum::CANONICAL_URL, 'https://nadil.io'),
            new MetadataObject(MetadataKeyEnum::FAVICON_URL, 'https://nadil.io/favicon.ico')
        ]
    ],
    'html lang' => [
        '<html lang="en"></html>',
        [
            new MetadataObject(MetadataKeyEnum::LOCALE, 'en')
        ]
    ],
    'json ld' => [
        '<script type="application/ld+json">
            {
                "@context": "https://schema.org",
                "@type": "Article",
                "datePublished": "2024-01-05T08:00:00+08:00",
                "dateModified": "2024-02-05T09:20:00+08:00",
                "author": [{
                    "@type": "Person",
                    "name": "Jane Doe",
                    "url": "https://example.com/profile/janedoe123"
                },{
                    "@type": "Person",
                    "name": "John Doe",
                    "url": "https://example.com/profile/johndoe123"
                }]
            }
        </script>',
        [
            new MetadataObject(MetadataKeyEnum::RICH_SCHEMA_PUBLISHED_TIME, new DateTimeImmutable('2024-01-05T08:00:00+08:00')),
            new MetadataObject(MetadataKeyEnum::RICH_SCHEMA_MODIFIED_TIME, new DateTimeImmutable('2024-02-05T09:20:00+08:00')),
            new MetadataObject(MetadataKeyEnum::RICH_SCHEMA_AUTHOR, new AuthorObject('Jane Doe', 'https://example.com/profile/janedoe123')),
            new MetadataObject(MetadataKeyEnum::RICH_SCHEMA_AUTHOR, new AuthorObject('John Doe', 'https://example.com/profile/johndoe123'))
        ]
    ],
]);

it('parses metadata', function (string $content, array $metadata) {

    $metadataParser = new MetadataParser($content);
    $parsedMetadata = $metadataParser->parse();

    expect($parsedMetadata)->toEqualCanonicalizing($metadata);

})->with('contents');


/*
 * getDateTimeFromString
 */
it('returns null when no date string is given', function () {
    expect(MetadataParser::getDateTimeFromString(''))->toBeNull();
});

it('returns null when invalid date string is given', function () {
    expect(MetadataParser::getDateTimeFromString('invalid date'))->toBeNull();
});

it('returns DateTimeInterface when valid date string is given: (2024-10-19T16:15:00Z)', function () {
    $date = MetadataParser::getDateTimeFromString('2024-10-19T16:15:00Z');
    expect($date)
        ->toBeInstanceOf(DateTimeInterface::class)
        ->and($date->format('Y-m-d H:i:s'))->toBe('2024-10-19 16:15:00');
});

it('returns DateTimeInterface when valid date string is given: (2024-10-19 16:15:00)', function () {
    $date = MetadataParser::getDateTimeFromString('2024-10-19 16:15:00');
    expect($date)
        ->toBeInstanceOf(DateTimeInterface::class)
        ->and($date->format('Y-m-d H:i:s'))->toBe('2024-10-19 16:15:00');
});