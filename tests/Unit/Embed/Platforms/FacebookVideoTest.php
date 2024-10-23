<?php

namespace Unit\Parsers;

use Hyvor\Unfold\Embed\Platforms\FacebookVideo;

//it('manual', function () {
//    $url = 'https://www.facebook.com/reel/416122534780426';
//    $facebook = new FacebookVideo($url);
//    $embed = $facebook->getEmbedHtml($facebook->match());
//
//    dd($embed);
//});

it('embeds facebook videos', function () {
    $url = 'https://www.facebook.com/username/videos/123456789';

    $parser = new FacebookVideo($url);
    $match = $parser->match();
    $response = $parser->parse($match);

    $html = $response->html;
    expect($html)->toContain('<div class="fb-video" data-href="' . $url);
    expect($html)->toContain(
        '<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v21.0">'
    );
});

it('matches', function ($url) {
    $facebook = new FacebookVideo($url);
    expect($facebook->match())->toBeArray();
})->with([
    // with username
    'https://www.facebook.com/username/videos/123456789',

    // video.php with id
    'https://www.facebook.com/video.php?id=123456789',
    'https://www.facebook.com/video.php?s=1&id=123456789',

    // video.php with v
    'https://www.facebook.com/video.php?v=123456789',
    'https://www.facebook.com/video.php?s=1&v=123456789',

    // watch
    'https://www.facebook.com/watch/?v=123456789',
    'https://www.facebook.com/watch/?s=1&v=123456789',
    'https://www.facebook.com/watch?v=123456789',

    // reel
    'https://www.facebook.com/reel/123456789',
]);
