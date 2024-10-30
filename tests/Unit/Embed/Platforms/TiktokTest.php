<?php

namespace Unit\Parsers;

use Hyvor\Unfold\Embed\Platforms\Tiktok;
use Hyvor\Unfold\UnfoldConfig;

//it('configs', function () {
//    $youtube = new Tiktok(
//        UnfoldConfig::withUrl(
//            'https://www.tiktok.com/@scout2015/video/6969696969696969696',
//        )
//    );
//    expect($youtube->oEmbedUrl())->toBe('https://www.tiktok.com/oembed');
//});

it('matches tiktok URLs', function (string $url) {
    $parser = new Tiktok(UnfoldConfig::withUrl($url));
    $match = $parser->match();
    expect($match)->toBeArray();
})->with([
    'https://www.tiktok.com/@scout2015/video/6969696969696969696',
]);

it('test', function () {
    $url = 'https://www.tiktok.com/@folyvtz/video/7404551626922528033?is_from_webapp=1&sender_device=pc';
    $parser = new Tiktok(UnfoldConfig::withUrl($url));
    $response = $parser->parse();

    expect($response)->toBe(
        '<blockquote class="tiktok-embed" cite="' . $url . '" data-video-id="7404551626922528033" style="max-width: 605px;min-width: 325px;" ><section><a href="' . $url . '" target="_blank">' . $url . '</a></section> </blockquote> <script async src="https://www.tiktok.com/embed.js"></script>'
    );
});
