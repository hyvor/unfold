<?php

namespace Unit\Parsers;

use Hyvor\Unfold\Embed\Platforms\Tiktok;
use Hyvor\Unfold\UnfoldConfig;
use Hyvor\Unfold\UnfoldMethod;

it('configs', function () {
    $youtube = new Tiktok(
        UnfoldConfig::withUrlAndMethod(
            'https://www.tiktok.com/@scout2015/video/6969696969696969696',
            UnfoldMethod::EMBED
        )
    );
    expect($youtube->oEmbedUrl())->toBe('https://www.tiktok.com/oembed');
});

it('matches tiktok URLs', function (string $url) {
    $parser = new Tiktok(UnfoldConfig::withUrlAndMethod($url, UnfoldMethod::EMBED));
    $match = $parser->match();
    expect($match)->toBeArray();
})->with([
    'https://www.tiktok.com/@scout2015',
    'https://www.tiktok.com/@scout2015/video/6969696969696969696',
]);

//it('test', function () {
//    $url = 'https://www.tiktok.com/@folyvtz/video/7404551626922528033?is_from_webapp=1&sender_device=pc';
//    $parser = new Tiktok($url);
//    $response = $parser->parse();
//
//    var_dump($response);
//    expect($response)->toBeObject();
//});
