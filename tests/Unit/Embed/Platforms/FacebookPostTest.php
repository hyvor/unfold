<?php

namespace Unit\Parsers;

use Hyvor\Unfold\Embed\Platforms\FacebookPost;
use Hyvor\Unfold\UnfoldConfig;

it('parses facebook embeds', function () {
    $url = 'https://www.facebook.com/geonarah/posts/pfbid027mqcVugNt1ChK6dwvjR2SkVJrtN754X1toi1XA1auyHgrng1g3bb3Ph2DoYANAhnl';

    $parser = new FacebookPost(UnfoldConfig::withUrl($url));
    $match = $parser->match();
    $response = $parser->parse($match);

    $html = $response;
    expect($html)->toContain('<div class="fb-post" data-href="' . $url);
    expect($html)->toContain(
        '<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v21.0">'
    );
});

it('matches', function ($url) {
    $parser = new FacebookPost(UnfoldConfig::withUrl($url));
    $match = $parser->match();
    expect($match)->toBeArray();
})->with([

    // post with username
    'https://www.facebook.com/geonarah/posts/027mqcVugNt1ChK6dwvjR2SkVJrtN754X1toi1XA1auyHgrng1g3bb3Ph2DoYANAhnl',
    'https://www.facebook.com/geonarah/activity/027mqcVugNt1ChK6dwvjR2SkVJrtN754X1toi1XA1auyHgrng1g3bb3Ph2Do',
    'https://www.facebook.com/geonarah/photos/027mqcVugNt1ChK6dwvjR2SkVJrtN754X1toi1XA1auyHgrng1g3bb3Ph2Do',
    'https://web.facebook.com/geonarah/posts/027mqcVugNt1ChK6dwvjR2SkVJrtN754X1toi1XA1auyHgrng1g3bb3Ph2DoYANAhnl',

    // photo.php
    'https://www.facebook.com/photo.php?fbid=934147948738763&set=a.414821727338057&type=3',
    'https://www.facebook.com/photo.php?set=a&fbid=934147948738763',
    'https://www.facebook.com/photo?fbid=94975234321362&set=a.37220824409111',

    // permalink.php
    'https://www.facebook.com/permalink.php?id=100064783864247&story_fbid=pfbid091orNDfpRpetrjS4JfNXPdctLCWG4mjhjP38xCzKxqvWFzHT9Cd4txnuV3MGs1zql',
    // story.php
    'https://www.facebook.com/story.php?story_fbid=1098197861821196&id=100048929783038',

    // media set
    'https://www.facebook.com/media/set/?set=a.301563726371715',
]);
