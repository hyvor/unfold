<?php

namespace Hyvor\Unfold\Tests\Unit;

use DateTimeImmutable;
use Hyvor\Unfold\Link\Metadata\Parsers\MetadataKeyEnum;
use Hyvor\Unfold\Objects\MetadataObject;
use Hyvor\Unfold\Unfolded\Unfolded;
use Hyvor\Unfold\Unfolded\UnfoldedAuthor;
use Hyvor\Unfold\Unfolded\UnfoldedTag;

it('gets title value', function () {
    $metadata = new MetadataObject(MetadataKeyEnum::TITLE, 'Title');
    expect(Unfolded::title([$metadata]))->toBe('Title');
});

it('gets description value', function () {
    $metadata = new MetadataObject(MetadataKeyEnum::OG_DESCRIPTION, 'OG Description');
    expect(Unfolded::description([$metadata]))->toBe('OG Description');
});

it('gets authors value', function () {
    $metadata = [
        new MetadataObject(MetadataKeyEnum::OG_ARTICLE_AUTHOR, new UnfoldedAuthor('Author1')),
        new MetadataObject(MetadataKeyEnum::OG_ARTICLE_AUTHOR, new UnfoldedAuthor('Author2')),
        new MetadataObject(MetadataKeyEnum::OG_ARTICLE_AUTHOR, new UnfoldedAuthor(url: 'https://author3.com')),
    ];
    expect(Unfolded::authors($metadata))->toEqual([
        new UnfoldedAuthor('Author1', null),
        new UnfoldedAuthor('Author2', null),
        new UnfoldedAuthor(null, 'https://author3.com'),
    ]);
});

it('gets tags value', function () {
    $metadata = [
        new MetadataObject(MetadataKeyEnum::OG_ARTICLE_TAG, new UnfoldedTag('Tag1')),
        new MetadataObject(MetadataKeyEnum::OG_ARTICLE_TAG, new UnfoldedTag('Tag2')),
    ];
    expect(Unfolded::tags($metadata))->toEqual([
        new UnfoldedTag('Tag1'),
        new UnfoldedTag('Tag2'),
    ]);
});

it('gets site name value', function () {
    $metadata = new MetadataObject(MetadataKeyEnum::OG_SITE_NAME, 'Site Name');
    expect(Unfolded::siteName([$metadata]))->toBe('Site Name');
});

it('gets site url value', function () {
    $metadata = new MetadataObject(MetadataKeyEnum::OG_URL, 'https://example.com');
    expect(Unfolded::siteUrl([$metadata]))->toBe('https://example.com');
});

it('gets canonical url value', function () {
    $metadata = new MetadataObject(MetadataKeyEnum::CANONICAL_URL, 'https://example.com/canonical');
    expect(Unfolded::canonicalUrl([$metadata]))->toBe('https://example.com/canonical');
});

it('gets published time value', function () {
    $metadata = new MetadataObject(
        MetadataKeyEnum::OG_ARTICLE_PUBLISHED_TIME,
        new DateTimeImmutable('2024-10-19T16:15:00Z')
    );
    expect(Unfolded::publishedTime([$metadata])->format('Y-m-d H:i:s'))->toBe('2024-10-19 16:15:00');
});

it('gets modified time value', function () {
    $metadata = new MetadataObject(
        MetadataKeyEnum::OG_ARTICLE_MODIFIED_TIME,
        new DateTimeImmutable('2024-10-19T16:15:00Z')
    );
    expect(Unfolded::modifiedTime([$metadata])->format('Y-m-d H:i:s'))->toBe('2024-10-19 16:15:00');
});

it('gets thumbnail url value', function () {
    $metadata = new MetadataObject(MetadataKeyEnum::OG_IMAGE, 'https://example.com/image.jpg');
    expect(Unfolded::thumbnailUrl([$metadata]))->toBe('https://example.com/image.jpg');
});

it('gets icon url value', function () {
    $metadata = new MetadataObject(MetadataKeyEnum::FAVICON_URL, 'https://example.com/favicon.ico');
    expect(Unfolded::iconUrl([$metadata]))->toBe('https://example.com/favicon.ico');
});

it('gets locale value', function () {
    $metadata = new MetadataObject(MetadataKeyEnum::OG_LOCALE, 'en');
    expect(Unfolded::locale([$metadata]))->toBe('en');
});
