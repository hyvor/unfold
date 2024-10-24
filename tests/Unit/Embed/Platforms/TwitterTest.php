<?php

namespace Unit\Parsers;

use Hyvor\Unfold\Embed\Platforms\Twitter;
use Hyvor\Unfold\UnfoldConfig;
use Hyvor\Unfold\UnfoldMethod;

it('configs', function () {
    $youtube = new Twitter(
        UnfoldConfig::withUrlAndMethod(
            'https://twitter.com/HyvorBlogs/status/1839476383136747730',
            UnfoldMethod::EMBED
        )
    );
    expect($youtube->oEmbedUrl())->toBe('https://publish.twitter.com/oembed');
});

it('matches reddit URLs', function (string $url) {
    $parser = new Twitter(UnfoldConfig::withUrlAndMethod($url, UnfoldMethod::EMBED));
    $match = $parser->match();
    expect($match)->toBeArray();
})->with([
    'https://twitter.com/HyvorBlogs',
    'https://twitter.com/HyvorBlogs/status/1839476383136747730',
    'https://www.twitter.com/HyvorBlogs/status/1839476383136747730',
    'https://x.com/HyvorBlogs',
    'https://x.com/HyvorBlogs/status/1839476383136747730',
    'https://www.x.com/HyvorBlogs/status/1839476383136747730'
]);

//it('test', function () {
//    $url = 'https://x.com/HyvorBlogs/status/1839476383136747730';
//    $parser = new Twitter($url);
//    $response = $parser->parse();
//
//    var_dump($response);
//    expect($response)->toBeObject();
//});
