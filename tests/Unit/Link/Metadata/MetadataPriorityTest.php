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
});