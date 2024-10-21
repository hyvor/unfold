<?php

namespace Hyvor\Unfold\Tests\Unit;

use Hyvor\Unfold\Link\Metadata\MetadataKeyType;
use Hyvor\Unfold\Link\Metadata\MetadataObject;
use Hyvor\Unfold\Link\Metadata\MetadataPriority;

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
});