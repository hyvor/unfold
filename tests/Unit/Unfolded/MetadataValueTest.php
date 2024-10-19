<?php

namespace Hyvor\Unfold\Tests\Unit;

use Hyvor\Unfold\Scraper\Metadata;
use Hyvor\Unfold\Scraper\MetadataKey;
use Hyvor\Unfold\Types\Unfolded;

it('gets title value', function () {

    $metadata = new Metadata(MetadataKey::TITLE, 'Title');
    expect(Unfolded::title([$metadata]))->toBe('Title');
});

it('gets description value', function () {

    $metadata = new Metadata(MetadataKey::OG_DESCRIPTION, 'OG Description');
    expect(Unfolded::description([$metadata]))->toBe('OG Description');
});

it('gets site name value', function () {

    $metadata = new Metadata(MetadataKey::OG_SITE_NAME, 'Site Name');
    expect(Unfolded::siteName([$metadata]))->toBe('Site Name');
});

it('gets site url value', function () {

    $metadata = new Metadata(MetadataKey::OG_URL, 'https://example.com');
    expect(Unfolded::siteUrl([$metadata]))->toBe('https://example.com');
});

it('gets canonical url value', function () {

    $metadata = new Metadata(MetadataKey::CANONICAL_URL, 'https://example.com/canonical');
    expect(Unfolded::canonicalUrl([$metadata]))->toBe('https://example.com/canonical');
});

it('gets published time value', function () {

    $metadata = new Metadata(MetadataKey::OG_ARTICLE_PUBLISHED_TIME, '2024-10-19T16:15:00Z');
    expect(Unfolded::publishedTime([$metadata])->format('Y-m-d H:i:s'))->toBe('2024-10-19 16:15:00');
});

it('gets modified time value', function () {

    $metadata = new Metadata(MetadataKey::OG_ARTICLE_MODIFIED_TIME, '2024-10-19T16:15:00Z');
    expect(Unfolded::modifiedTime([$metadata])->format('Y-m-d H:i:s'))->toBe('2024-10-19 16:15:00');
});

it('gets thumbnail url value', function () {

    $metadata = new Metadata(MetadataKey::OG_IMAGE, 'https://example.com/image.jpg');
    expect(Unfolded::thumbnailUrl([$metadata]))->toBe('https://example.com/image.jpg');
});

it('gets icon url value', function () {

    $metadata = new Metadata(MetadataKey::FAVICON, 'https://example.com/favicon.ico');
    expect(Unfolded::iconUrl([$metadata]))->toBe('https://example.com/favicon.ico');
});

it('gets locale value', function () {

    $metadata = new Metadata(MetadataKey::OG_LOCALE, 'en');
    expect(Unfolded::locale([$metadata]))->toBe('en');
});