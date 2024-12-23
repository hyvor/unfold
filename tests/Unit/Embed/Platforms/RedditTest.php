<?php

namespace Unit\Parsers;

use Hyvor\Unfold\Embed\Platforms\Reddit;
use Hyvor\Unfold\UnfoldConfig;

it('configs', function () {
    $reddit = new Reddit(
        UnfoldConfig::withUrl(
            'https://www.reddit.com/r/math/comments/66k3c0/ive_just_start_reading_this_1910_book_calculus/',
        )
    );
    expect($reddit->oEmbedUrl())->toBe('https://www.reddit.com/oembed');
});

it('matches reddit URLs', function (string $url) {
    $parser = new Reddit(UnfoldConfig::withUrl($url));
    $match = $parser->match();
    expect($match)->toBeArray();
})->with([
    'https://www.reddit.com/r/math/comments/66k3c0/ive_just_start_reading_this_1910_book_calculus/',
    'https://reddit.com/r/math/comments/66k3c0/ive_just_start_reading_this_1910_book_calculus/',
    'https://old.reddit.com/r/math/comments/66k3c0/ive_just_start_reading_this_1910_book_calculus/'
]);

//it('test', function () {
//    $url = 'https://www.reddit.com/r/math/comments/66k3c0/ive_just_start_reading_this_1910_book_calculus/';
//    $parser = new Reddit($url);
//    $response = $parser->parse();
//
//    dd($response->html);
//    expect($response)->toBeObject();
//});
