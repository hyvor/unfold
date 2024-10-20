<?php

namespace Hyvor\Unfold\Tests\Unit;

use Hyvor\Unfold\MetadataParsers\MetadataKeyEnum;
use Hyvor\Unfold\Objects\AuthorObject;
use Hyvor\Unfold\Objects\MetadataObject;
use Hyvor\Unfold\Objects\TagObject;
use Hyvor\Unfold\Objects\UnfoldedObject;
use DateTimeImmutable;

it('gets title value', function () {

    $metadata = new MetadataObject(MetadataKeyEnum::TITLE, 'Title');
    expect(UnfoldedObject::title([$metadata]))->toBe('Title');
});

it('gets description value', function () {

    $metadata = new MetadataObject(MetadataKeyEnum::OG_DESCRIPTION, 'OG Description');
    expect(UnfoldedObject::description([$metadata]))->toBe('OG Description');
});

it('gets authors value', function () {

    $metadata = [
        new MetadataObject(MetadataKeyEnum::OG_ARTICLE_AUTHOR, new AuthorObject('Author1')),
        new MetadataObject(MetadataKeyEnum::OG_ARTICLE_AUTHOR, new AuthorObject('Author2')),
        new MetadataObject(MetadataKeyEnum::OG_ARTICLE_AUTHOR, new AuthorObject(url: 'https://author3.com')),
    ];
    expect(UnfoldedObject::authors($metadata))->toEqual([
        new AuthorObject('Author1', null),
        new AuthorObject('Author2', null),
        new AuthorObject(null, 'https://author3.com'),
    ]);
});

it('gets tags value', function () {

    $metadata = [
        new MetadataObject(MetadataKeyEnum::OG_ARTICLE_TAG, new TagObject('Tag1')),
        new MetadataObject(MetadataKeyEnum::OG_ARTICLE_TAG, new TagObject('Tag2')),
    ];
    expect(UnfoldedObject::tags($metadata))->toEqual([
        new TagObject('Tag1'),
        new TagObject('Tag2'),
    ]);
});

it('gets site name value', function () {

    $metadata = new MetadataObject(MetadataKeyEnum::OG_SITE_NAME, 'Site Name');
    expect(UnfoldedObject::siteName([$metadata]))->toBe('Site Name');
});

it('gets site url value', function () {

    $metadata = new MetadataObject(MetadataKeyEnum::OG_URL, 'https://example.com');
    expect(UnfoldedObject::siteUrl([$metadata]))->toBe('https://example.com');
});

it('gets canonical url value', function () {

    $metadata = new MetadataObject(MetadataKeyEnum::CANONICAL_URL, 'https://example.com/canonical');
    expect(UnfoldedObject::canonicalUrl([$metadata]))->toBe('https://example.com/canonical');
});

it('gets published time value', function () {

    $metadata = new MetadataObject(MetadataKeyEnum::OG_ARTICLE_PUBLISHED_TIME, new DateTimeImmutable('2024-10-19T16:15:00Z'));
    expect(UnfoldedObject::publishedTime([$metadata])->format('Y-m-d H:i:s'))->toBe('2024-10-19 16:15:00');
});

it('gets modified time value', function () {

    $metadata = new MetadataObject(MetadataKeyEnum::OG_ARTICLE_MODIFIED_TIME, new DateTimeImmutable('2024-10-19T16:15:00Z'));
    expect(UnfoldedObject::modifiedTime([$metadata])->format('Y-m-d H:i:s'))->toBe('2024-10-19 16:15:00');
});

it('gets thumbnail url value', function () {

    $metadata = new MetadataObject(MetadataKeyEnum::OG_IMAGE, 'https://example.com/image.jpg');
    expect(UnfoldedObject::thumbnailUrl([$metadata]))->toBe('https://example.com/image.jpg');
});

it('gets icon url value', function () {

    $metadata = new MetadataObject(MetadataKeyEnum::FAVICON_URL, 'https://example.com/favicon.ico');
    expect(UnfoldedObject::iconUrl([$metadata]))->toBe('https://example.com/favicon.ico');
});

it('gets locale value', function () {

    $metadata = new MetadataObject(MetadataKeyEnum::OG_LOCALE, 'en');
    expect(UnfoldedObject::locale([$metadata]))->toBe('en');
});
