<?php

namespace Unit\Parsers;

use Hyvor\Unfold\Embed\Platforms\Reddit;

it('configs', function () {
    $youtube = new Reddit(
        'https://www.reddit.com/r/math/comments/66k3c0/ive_just_start_reading_this_1910_book_calculus/'
    );
    expect($youtube->oEmbedUrl())->toBe('https://www.reddit.com/oembed');
});

it('matches reddit URLs', function (string $url) {
    $parser = new Reddit($url);
    $match = $parser->match();
    expect($match)->toBeArray();
})->with([
    'https://www.reddit.com/r/math/comments/66k3c0/ive_just_start_reading_this_1910_book_calculus/',
    'https://reddit.com/r/math/comments/66k3c0/ive_just_start_reading_this_1910_book_calculus/',
    'https://old.reddit.com/r/math/comments/66k3c0/ive_just_start_reading_this_1910_book_calculus/'
]);

//it('test', function () {
//    $url = 'https://old.reddit.com/r/math/comments/66k3c0/ive_just_start_reading_this_1910_book_calculus/';
//    $parser = new Reddit($url);
//    $response = $parser->parse();
//
//    var_dump($response);
//    expect($response)->toBeObject();
//});
