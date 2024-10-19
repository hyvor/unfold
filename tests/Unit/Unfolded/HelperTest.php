<?php

namespace Hyvor\Unfold\Tests\Unit;

use DateTimeInterface;
use Hyvor\Unfold\MetadataParsers\MetadataKeyEnum;
use Hyvor\Unfold\Objects\MetadataObject;
use Hyvor\Unfold\Objects\UnfoldedObject;

/**
 * getMetadataFromKeys
*/
global $metadata;
$metadata = [
    new MetadataObject(MetadataKeyEnum::TWITTER_TITLE, 'Twitter Title'),
    new MetadataObject(MetadataKeyEnum::OG_TITLE, 'OG Title'),
    new MetadataObject(MetadataKeyEnum::DESCRIPTION, 'Description'),
    new MetadataObject(MetadataKeyEnum::TITLE, 'Title'),
];

it('gets metadata from key array', function () {

    global $metadata;
    $metadataValue = UnfoldedObject::getMetadataFromKeys($metadata, [
        MetadataKeyEnum::TITLE,
        MetadataKeyEnum::OG_TITLE,
        MetadataKeyEnum::TWITTER_TITLE
    ]);
    expect($metadataValue)->toBe('Title');
});

it('gets metadata from key array 2', function () {

    global $metadata;
    $metadataValue = UnfoldedObject::getMetadataFromKeys($metadata, [
        MetadataKeyEnum::OG_TITLE,
        MetadataKeyEnum::TITLE,
        MetadataKeyEnum::TWITTER_TITLE
    ]);
    expect($metadataValue)->toBe('OG Title');
});

it('returns null when no metadata found', function () {

    global $metadata;
    $metadataValue = UnfoldedObject::getMetadataFromKeys($metadata, [
        MetadataKeyEnum::OG_IMAGE,
    ]);
    expect($metadataValue)->toBeNull();
});

it('returns null when no keys are given', function () {

    global $metadata;
    $metadataValue = UnfoldedObject::getMetadataFromKeys($metadata, []);
    expect($metadataValue)->toBeNull();
});


/*
 * getDateTimeFromString
 */
it('returns null when no date string is given', function () {
    expect(UnfoldedObject::getDateTimeFromString(''))->toBeNull();
});

it('returns null when invalid date string is given', function () {
    expect(UnfoldedObject::getDateTimeFromString('invalid date'))->toBeNull();
});

it('returns DateTimeInterface when valid date string is given: (2024-10-19T16:15:00Z)', function () {
    $date = UnfoldedObject::getDateTimeFromString('2024-10-19T16:15:00Z');
    expect($date)
        ->toBeInstanceOf(DateTimeInterface::class)
        ->and($date->format('Y-m-d H:i:s'))->toBe('2024-10-19 16:15:00');
});

it('returns DateTimeInterface when valid date string is given: (2024-10-19 16:15:00)', function () {
    $date = UnfoldedObject::getDateTimeFromString('2024-10-19 16:15:00');
    expect($date)
        ->toBeInstanceOf(DateTimeInterface::class)
        ->and($date->format('Y-m-d H:i:s'))->toBe('2024-10-19 16:15:00');
});