<?php

namespace Hyvor\Unfold\Tests\Unit;

use Hyvor\Unfold\Link\Metadata\MetadataKeyType;
use Hyvor\Unfold\Link\Metadata\MetadataObject;
use Hyvor\Unfold\Unfolded\Unfolded;

/**
 * getMetadataFromKeys
 */
global $metadata;
$metadata = [
    new MetadataObject(MetadataKeyType::TWITTER_TITLE, 'Twitter Title'),
    new MetadataObject(MetadataKeyType::OG_TITLE, 'OG Title'),
    new MetadataObject(MetadataKeyType::DESCRIPTION, 'Description'),
    new MetadataObject(MetadataKeyType::TITLE, 'Title'),
];

it('gets metadata from key array', function () {
    global $metadata;
    $metadataValue = Unfolded::getMetadataFromKeys($metadata, [
        MetadataKeyType::TITLE,
        MetadataKeyType::OG_TITLE,
        MetadataKeyType::TWITTER_TITLE
    ]);
    expect($metadataValue)->toBe('Title');
});

it('gets metadata from key array 2', function () {
    global $metadata;
    $metadataValue = Unfolded::getMetadataFromKeys($metadata, [
        MetadataKeyType::OG_TITLE,
        MetadataKeyType::TITLE,
        MetadataKeyType::TWITTER_TITLE
    ]);
    expect($metadataValue)->toBe('OG Title');
});

it('returns null when no metadata found', function () {
    global $metadata;
    $metadataValue = Unfolded::getMetadataFromKeys($metadata, [
        MetadataKeyType::OG_IMAGE,
    ]);
    expect($metadataValue)->toBeNull();
});

it('returns null when no keys are given', function () {
    global $metadata;
    $metadataValue = Unfolded::getMetadataFromKeys($metadata, []);
    expect($metadataValue)->toBeNull();
});
