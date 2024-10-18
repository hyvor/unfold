<?php

namespace Hyvor\Unfold\Tests\Feature;

use Hyvor\Unfold\Scraper\Scraper;

it('gets web content', function () {

    $scraper = new Scraper('https://supun.io/');
    $scraper->getWebContent();
    expect($scraper->getContent())->toContain('<a class="article" href="https://supun.io/raspihole">');
});

it('gets og:tags', function () {

    $scraper = new Scraper('https://supun.io/');
    $scraper->handle();
    expect($scraper->getMetadata())->toBe('hi');
});