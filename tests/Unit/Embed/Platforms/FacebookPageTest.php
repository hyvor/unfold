<?php

namespace Unit\Parsers;

use Hyvor\Unfold\Embed\Embed;
use Hyvor\Unfold\Embed\Platforms\FacebookPage;
use Hyvor\Unfold\Embed\Platforms\FacebookPost;

it('matches a facebook page', function () {
    $url = 'https://www.facebook.com/GMANetwork/about';
    $parser = new FacebookPage($url);

    $response = $parser->parse($parser->match());
    var_dump($response->html);
    expect($response->html)->toBeString();
});

it('embed class prioritizes facebook post before page', function () {
    $url = 'https://www.facebook.com/permalink.php?story_fbid=10159000000000000&id=100000000000000';
    $match = Embed::getMatchingParser($url);
    expect($match['parser'])->toBeInstanceOf(FacebookPost::class);
    expect($match['matches'])->toBeArray();
})
    ->with([
        'https://www.facebook.com/permalink.php?story_fbid=10159000000000000&id=100000000000000',
        'https://www.facebook.com/media/set/?set=a.10159000000000000&type=3',
        'https://www.facebook.com/photo.php?fbid=10159000000000000',
    ]);

it('matches', function ($url) {
    $parser = new FacebookPage($url);
    expect($parser->match())->toBeArray();
})->with([
    'https://www.facebook.com/MyPage',
    'https://www.facebook.com/MyPage/about',
    'https://www.facebook.com/MyPage/photos',
    'https://www.facebook.com/MyPage/videos',
    'https://www.facebook.com/MyPage/events',
    'https://www.facebook.com/MyPage/timeline',
]);

it('does not match', function ($url) {
    $parser = new FacebookPage($url);
    expect($parser->match())->toBeFalse();
})->with([
    'https://www.facebook.com/Mypage/other',
]);
