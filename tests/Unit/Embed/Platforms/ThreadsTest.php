<?php

namespace Unit\Parsers;

use Hyvor\Unfold\Embed\Platforms\Threads;
use Hyvor\Unfold\UnfoldConfig;

it('matches', function ($url, $id) {
    $parser = new Threads(UnfoldConfig::withUrl($url));
    $match = $parser->match();
    expect($match)->toBeArray();
    expect($match['id'])->toBe($id);
})->with([
    ['https://www.threads.net/@wll11.3/post/DBs3tgVsXw2?hl=en', 'DBs3tgVsXw2'],
    [
        'https://www.threads.net/@davidattenborough_fans/post/DBtZgMHMPi3?xmt=AQGz4TL1x9Im1qsozYmPhq62d7MG-EIDBTi_9F-gj0Ephg',
        'DBtZgMHMPi3'
    ]
]);

it('returns embed', function () {
    $url = 'https://www.threads.net/@wll11.3/post/DBs3tgVsXw2?hl=en';
    $parser = new Threads(UnfoldConfig::withUrl($url));
    $response = $parser->parse();
    
    expect($response)->toStartWith(
        '<blockquote class="text-post-media" data-text-post-permalink="https://www.threads.net/@wll11.3/post/DBs3tgVsXw2?hl=en" data-text-post-version="0"'
    );
    expect($response)->toContain('<script async src="https://www.threads.net/embed.js"></script>');
});