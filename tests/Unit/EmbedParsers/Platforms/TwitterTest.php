<?php

namespace Unit\Parsers;

use Hyvor\Unfold\Embed\Platforms\Twitter;

it('configs', function () {
    $youtube = new Twitter(
        'https://twitter.com/HyvorBlogs/status/1839476383136747730'
    );
    expect($youtube->oEmbedUrl())->toBe('https://publish.twitter.com/oembed');
});

it('matches reddit URLs', function (string $url) {
    $parser = new Twitter($url);
    $match = $parser->match();
    expect($match)->toBeTrue();
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
