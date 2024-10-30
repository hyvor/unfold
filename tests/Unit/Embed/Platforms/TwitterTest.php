<?php

namespace Unit\Parsers;

use Hyvor\Unfold\Embed\Platforms\Twitter;
use Hyvor\Unfold\UnfoldConfig;

it('matches reddit URLs', function (string $url) {
    $parser = new Twitter(UnfoldConfig::withUrl($url));
    $match = $parser->match();
    expect($match)->toBeArray();
})->with([
    // 'https://twitter.com/HyvorBlogs',
    'https://twitter.com/HyvorBlogs/status/1839476383136747730',
    'https://www.twitter.com/HyvorBlogs/status/1839476383136747730',
    // 'https://x.com/HyvorBlogs',
    'https://x.com/HyvorBlogs/status/1839476383136747730',
    'https://www.x.com/HyvorBlogs/status/1839476383136747730'
]);

it('returns embed code for posts', function () {
    $url = 'https://twitter.com/HyvorBlogs/status/1839476383136747730';
    $parser = new Twitter(UnfoldConfig::withUrl($url));
    $match = $parser->match();
    expect($match[1])->toBe('HyvorBlogs/status/1839476383136747730');

    $response = $parser->parse($match);
    expect($response)->toBe(
        '<blockquote class="twitter-tweet" data-dnt="true"><a href="https://twitter.com/HyvorBlogs/status/1839476383136747730">https://twitter.com/HyvorBlogs/status/1839476383136747730</a></blockquote><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>'
    );
});

it('returns embed code for x.com links', function () {
    $url = 'https://x.com/HyvorBlogs/status/1839476383136747730';
    $parser = new Twitter(UnfoldConfig::withUrl($url));
    $match = $parser->match();
    expect($match[1])->toBe('HyvorBlogs/status/1839476383136747730');

    $response = $parser->parse($match);
    expect($response)->toBe(
        '<blockquote class="twitter-tweet" data-dnt="true"><a href="https://twitter.com/HyvorBlogs/status/1839476383136747730">https://twitter.com/HyvorBlogs/status/1839476383136747730</a></blockquote><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>'
    );
});

//it('test', function () {
//    $url = 'https://x.com/HyvorBlogs/status/1839476383136747730';
//    $parser = new Twitter($url);
//    $response = $parser->parse();
//
//    var_dump($response);
//    expect($response)->toBeObject();
//});
