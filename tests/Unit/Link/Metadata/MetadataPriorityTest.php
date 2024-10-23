<?php

namespace Hyvor\Unfold\Tests\Unit;

use Hyvor\Unfold\Link\Metadata\MetadataKeyType;
use Hyvor\Unfold\Link\Metadata\MetadataObject;
use Hyvor\Unfold\Link\Metadata\MetadataPriority;
use Hyvor\Unfold\Unfolded\UnfoldedAuthor;
use Hyvor\Unfold\Unfolded\UnfoldedTag;

it('prioritizes title', function () {
    $metadata = [
        new MetadataObject(MetadataKeyType::DESCRIPTION, 'description'), // ignored
        new MetadataObject(MetadataKeyType::OG_TITLE, 'og title'),
        new MetadataObject(MetadataKeyType::TITLE, 'title'),
    ];

    $priority = new MetadataPriority($metadata);
    $title = $priority->title();
    expect($title)->toBe('title');
});

it('prioritized authors', function () {
    $metadata = [
        new MetadataObject(MetadataKeyType::OG_ARTICLE_AUTHOR, 'Author1'),
        new MetadataObject(MetadataKeyType::OG_ARTICLE_AUTHOR, 'Author2'),
        new MetadataObject(MetadataKeyType::OG_ARTICLE_AUTHOR, 'Author3'),
        // some tags
        new MetadataObject(MetadataKeyType::OG_ARTICLE_TAG, 'Tag1'),
        new MetadataObject(MetadataKeyType::OG_ARTICLE_TAG, 'Tag2'),
    ];

    $priority = new MetadataPriority($metadata);
    $authors = $priority->authors();
    expect($authors)->toEqual([
        'Author1',
        'Author2',
        'Author3',
    ]);
});

it('with already correct sort', function () {
    $metadata = [
        new MetadataObject(MetadataKeyType::OG_SITE_NAME, 'OG Site name'),
        new MetadataObject(MetadataKeyType::TWITTER_SITE, 'Twitter Site Name'),
    ];

    $priority = new MetadataPriority($metadata);
    $authors = $priority->siteName();
    expect($authors)->toEqual('OG Site name');
});

it('gets site url', function () {
    $metadata = [
        new MetadataObject(MetadataKeyType::CANONICAL_URL, 'https://example.com/php'),
    ];
    $priority = new MetadataPriority($metadata);
    $siteUrl = $priority->siteUrl('https://hyvor.com/js');
    expect($siteUrl)->toEqual('https://example.com');

    $priority2 = new MetadataPriority([]);
    $siteUrl2 = $priority2->siteUrl('https://hyvor.com/js');
    expect($siteUrl2)->toBe('https://hyvor.com');

    // empty host
    $priority3 = new MetadataPriority([]);
    $siteUrl3 = $priority3->siteUrl('invalid url');
    expect($siteUrl3)->toBeNull();

    // invalid url
    $priority4 = new MetadataPriority([]);
    $siteUrl4 = $priority4->siteUrl(')@9d8q29cooal');
    expect($siteUrl4)->toBeNull();


    // og site url
    $metadata = [
        new MetadataObject(MetadataKeyType::OG_URL, 'https://example.com/php'),
    ];
    $priority5 = new MetadataPriority($metadata);
    $siteUrl5 = $priority5->siteUrl('https://hyvor.com/js');
    expect($siteUrl5)->toEqual('https://example.com');
});


describe('each one', function () {
    it('gets title value', function () {
        $metadata = new MetadataObject(MetadataKeyType::TITLE, 'Title');
        $priority = new MetadataPriority([$metadata]);
        expect($priority->title())->toBe('Title');
    });

    it('gets description value', function () {
        $metadata = new MetadataObject(MetadataKeyType::OG_DESCRIPTION, 'OG Description');
        $priority = new MetadataPriority([$metadata]);
        expect($priority->description())->toBe('OG Description');
    });

    it('gets authors value', function () {
        $metadata = [
            new MetadataObject(MetadataKeyType::OG_ARTICLE_AUTHOR, new UnfoldedAuthor('Author1')),
            new MetadataObject(MetadataKeyType::OG_ARTICLE_AUTHOR, new UnfoldedAuthor('Author2')),
            new MetadataObject(MetadataKeyType::OG_ARTICLE_AUTHOR, new UnfoldedAuthor(url: 'https://author3.com')),
        ];
        $priority = new MetadataPriority($metadata);
        expect($priority->authors())->toEqual([
            new UnfoldedAuthor('Author1', null),
            new UnfoldedAuthor('Author2', null),
            new UnfoldedAuthor(null, 'https://author3.com'),
        ]);
    });

    it('gets tags value', function () {
        $metadata = [
            new MetadataObject(MetadataKeyType::OG_ARTICLE_TAG, new UnfoldedTag('Tag1')),
            new MetadataObject(MetadataKeyType::OG_ARTICLE_TAG, new UnfoldedTag('Tag2')),
        ];
        $priority = new MetadataPriority($metadata);
        expect($priority->tags())->toEqual([
            new UnfoldedTag('Tag1'),
            new UnfoldedTag('Tag2'),
        ]);
    });

    it('gets site name value', function () {
        $metadata = new MetadataObject(MetadataKeyType::OG_SITE_NAME, 'Site Name');
        $priority = new MetadataPriority([$metadata]);
        expect($priority->siteName())->toBe('Site Name');
    });

    it('gets site url value', function () {
        $metadata = new MetadataObject(MetadataKeyType::OG_URL, 'https://example.com');
        $priority = new MetadataPriority([$metadata]);
        expect($priority->siteUrl('https://jim.com'))->toBe('https://example.com');
    });

    it('gets canonical url value', function () {
        $metadata = new MetadataObject(MetadataKeyType::CANONICAL_URL, 'https://example.com/canonical');
        $priority = new MetadataPriority([$metadata]);
        expect($priority->canonicalUrl())->toBe('https://example.com/canonical');
    });

    it('gets published time value', function () {
        $metadata = new MetadataObject(
            MetadataKeyType::OG_ARTICLE_PUBLISHED_TIME,
            new \DateTimeImmutable('2024-10-19T16:15:00Z')
        );
        $priority = new MetadataPriority([$metadata]);
        expect($priority->publishedTime([$metadata])->format('Y-m-d H:i:s'))->toBe('2024-10-19 16:15:00');
    });

    it('gets modified time value', function () {
        $metadata = new MetadataObject(
            MetadataKeyType::OG_ARTICLE_MODIFIED_TIME,
            new \DateTimeImmutable('2024-10-19T16:15:00Z')
        );
        $priority = new MetadataPriority([$metadata]);
        expect($priority->modifiedTime([$metadata])->format('Y-m-d H:i:s'))->toBe('2024-10-19 16:15:00');
    });

    it('gets thumbnail url value', function () {
        $metadata = new MetadataObject(MetadataKeyType::OG_IMAGE, 'https://example.com/image.jpg');
        $priority = new MetadataPriority([$metadata]);
        expect($priority->thumbnailUrl())->toBe('https://example.com/image.jpg');
    });

    it('gets icon url value', function () {
        $metadata = new MetadataObject(MetadataKeyType::FAVICON_URL, 'https://example.com/favicon.ico');
        $priority = new MetadataPriority([$metadata]);
        expect($priority->iconUrl())->toBe('https://example.com/favicon.ico');
    });

    it('gets locale value', function () {
        $metadata = new MetadataObject(MetadataKeyType::OG_LOCALE, 'en');
        $priority = new MetadataPriority([$metadata]);
        expect($priority->locale())->toBe('en');
    });
});
