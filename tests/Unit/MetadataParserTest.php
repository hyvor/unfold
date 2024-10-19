<?php

namespace Hyvor\Unfold\Tests\Unit;

use Hyvor\Unfold\Scraper\Metadata;
use Hyvor\Unfold\Scraper\MetadataKey;
use Hyvor\Unfold\Scraper\MetadataParser;

dataset('contents', [
    ['<html><head><meta property="og:title" content="Nadil Karunarathna" /></head></html>', new Metadata(MetadataKey::OG_TITLE, 'Nadil Karunarathna')],
    ['<html><head><meta property="og:type" content="website" /></head></html>', new Metadata(MetadataKey::OG_TYPE, 'website')],
    ['<html><head><meta property="og:image" content="https://nadil.io/image.jpg" /></head></html>', new Metadata(MetadataKey::OG_IMAGE, 'https://nadil.io/image.jpg')],
    ['<html><head><meta property="og:url" content="https://nadil.io" /></head></html>', new Metadata(MetadataKey::OG_URL, 'https://nadil.io')],

    ['<html><head><meta property="og:audio" content="https://nadil.io/audio.mp3" /></head></html>', new Metadata(MetadataKey::OG_AUDIO, 'https://nadil.io/audio.mp3')],
    ['<html><head><meta property="og:description" content="Personal Blog" /></head></html>', new Metadata(MetadataKey::OG_DESCRIPTION, 'Personal Blog')],
    ['<html><head><meta property="og:locale" content="en_US" /></head></html>', new Metadata(MetadataKey::OG_LOCALE, 'en_US')],
    ['<html><head><meta property="og:locale:alternate" content="fr_FR" /></head></html>', new Metadata(MetadataKey::OG_LOCALE_ALTERNATE, 'fr_FR')],
    ['<html><head><meta property="og:locale:alternate" content="si_LK" /></head></html>', new Metadata(MetadataKey::OG_LOCALE_ALTERNATE, 'si_LK')],
    ['<html><head><meta property="og:site_name" content="Nadil Karunarathna" /></head></html>', new Metadata(MetadataKey::OG_SITE_NAME, 'Nadil Karunarathna')],
    ['<html><head><meta property="og:video" content="https://nadil.io/video.mp4" /></head></html>', new Metadata(MetadataKey::OG_VIDEO, 'https://nadil.io/video.mp4')],

]);

it('parses metadata', function (string $content, Metadata $metadata) {

    $metadataParser = new MetadataParser($content);
    $parsedMetadata = $metadataParser->parse();

    expect($parsedMetadata)->toEqualCanonicalizing([$metadata]);

})->with('contents');
