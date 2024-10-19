<?php

namespace Hyvor\Unfold\Tests\Unit;

use Hyvor\Unfold\Scraper\Metadata;
use Hyvor\Unfold\Scraper\MetadataKey;
use Hyvor\Unfold\Types\Unfolded;
use DateTimeInterface;

/**
 * getMetadataFromKeys
*/
global $metadata;
$metadata = [
    new Metadata(MetadataKey::TWITTER_TITLE, 'Twitter Title'),
    new Metadata(MetadataKey::OG_TITLE, 'OG Title'),
    new Metadata(MetadataKey::DESCRIPTION, 'Description'),
    new Metadata(MetadataKey::TITLE, 'Title'),
];

it('gets metadata from key array', function () {

    global $metadata;
    $metadataValue = Unfolded::getMetadataFromKeys($metadata, [
        MetadataKey::TITLE,
        MetadataKey::OG_TITLE,
        MetadataKey::TWITTER_TITLE
    ]);
    expect($metadataValue)->toBe('Title');
});

it('gets metadata from key array 2', function () {

    global $metadata;
    $metadataValue = Unfolded::getMetadataFromKeys($metadata, [
        MetadataKey::OG_TITLE,
        MetadataKey::TITLE,
        MetadataKey::TWITTER_TITLE
    ]);
    expect($metadataValue)->toBe('OG Title');
});

it('returns null when no metadata found', function () {

    global $metadata;
    $metadataValue = Unfolded::getMetadataFromKeys($metadata, [
        MetadataKey::OG_IMAGE,
    ]);
    expect($metadataValue)->toBeNull();
});

it('returns null when no keys are given', function () {

    global $metadata;
    $metadataValue = Unfolded::getMetadataFromKeys($metadata, []);
    expect($metadataValue)->toBeNull();
});


/*
 * getDateTimeFromString
 */
it('returns null when no date string is given', function () {
    expect(Unfolded::getDateTimeFromString(''))->toBeNull();
});

it('returns null when invalid date string is given', function () {
    expect(Unfolded::getDateTimeFromString('invalid date'))->toBeNull();
});

it('returns DateTimeInterface when valid date string is given: (2024-10-19T16:15:00Z)', function () {
    $date = Unfolded::getDateTimeFromString('2024-10-19T16:15:00Z');
    expect($date)
        ->toBeInstanceOf(DateTimeInterface::class)
        ->and($date->format('Y-m-d H:i:s'))->toBe('2024-10-19 16:15:00');
});

it('returns DateTimeInterface when valid date string is given: (2024-10-19 16:15:00)', function () {
    $date = Unfolded::getDateTimeFromString('2024-10-19 16:15:00');
    expect($date)
        ->toBeInstanceOf(DateTimeInterface::class)
        ->and($date->format('Y-m-d H:i:s'))->toBe('2024-10-19 16:15:00');
});