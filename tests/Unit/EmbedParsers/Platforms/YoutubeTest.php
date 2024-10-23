<?php

namespace Unit\Parsers;

use Hyvor\Unfold\Embed\Platforms\Youtube;

it('matches video', function () {
    $url = 'https://www.youtube.com/watch?v=TdrL3QxjyVw';
    $parser = new Youtube($url);
    $match = $parser->match();
    expect($match[1])->toBe('TdrL3QxjyVw');

    $response = $parser->parse($match);

    expect($response->html)->toBe(
        '<div style="position:relative;left:0;width:100%;height:0;padding-bottom:56.25%;"><iframe src="https://www.youtube.com/embed/TdrL3QxjyVw" style="position: absolute;top:0;left:0;width:100%;height:100%;border:0;" allow="fullscreen;accelerometer;clipboard-write;encrypted-media;gyroscope;picture-in-picture;web-share;"></iframe></div>'
    );
});

it('matches playlist', function () {
    $url = 'https://www.youtube.com/playlist?list=PLAqhIrjkxbuWI23v9cThsA9GvCAUhRvKZ';
    $parser = new Youtube($url);
    $match = $parser->match();
    expect($match[1])->toBe('PLAqhIrjkxbuWI23v9cThsA9GvCAUhRvKZ');

    $response = $parser->parse($match);

    expect($response->html)->toBe(
        '<div style="position:relative;left:0;width:100%;height:0;padding-bottom:56.25%;"><iframe src="https://www.youtube.com/embed?listType=playlist&list=PLAqhIrjkxbuWI23v9cThsA9GvCAUhRvKZ" style="position: absolute;top:0;left:0;width:100%;height:100%;border:0;" allow="fullscreen;accelerometer;clipboard-write;encrypted-media;gyroscope;picture-in-picture;web-share;"></iframe></div>'
    );
});

it('matches user', function () {
    $url = 'https://www.youtube.com/user/GoogleDevelopers';
    $parser = new Youtube($url);
    $match = $parser->match();
    expect($match[1])->toBe('GoogleDevelopers');

    $response = $parser->parse($match);

    expect($response->html)->toBe(
        '<div style="position:relative;left:0;width:100%;height:0;padding-bottom:56.25%;"><iframe src="https://www.youtube.com/embed?listType=user_uploads&list=GoogleDevelopers" style="position: absolute;top:0;left:0;width:100%;height:100%;border:0;" allow="fullscreen;accelerometer;clipboard-write;encrypted-media;gyroscope;picture-in-picture;web-share;"></iframe></div>'
    );
});

it('matches short', function () {
    $url = 'https://www.youtube.com/shorts/uehCDW1fxUw';
    $parser = new Youtube($url);
    $match = $parser->match();
    expect($match[1])->toBe('uehCDW1fxUw');

    $response = $parser->parse($match);

    expect($response->html)->toBe(
        '<div style="max-width:calc(56.25vh - 54px)"><div style="position:relative;left:0;width:100%;height:0;padding-bottom:177.78%;"><iframe src="https://www.youtube.com/embed/uehCDW1fxUw" style="position: absolute;top:0;left:0;width:100%;height:100%;border:0;" allow="fullscreen;accelerometer;clipboard-write;encrypted-media;gyroscope;picture-in-picture;web-share;"></iframe></div></div>'
    );
});


it('matches youtube URLs', function (string $url) {
    $parser = new Youtube($url);
    $match = $parser->match();
    expect($match)->toBeArray();
    expect($match[1])->toBe('lHZwlzOUOZ4');
})->with([

    // youtube.com
    'https://www.youtube.com/watch?v=lHZwlzOUOZ4',
    // v
    'https://www.youtube.com/v/lHZwlzOUOZ4',

    // youtu.be
    'https://youtu.be/lHZwlzOUOZ4?si=q75TsgT5bAs9VLZn',

    // playlist
    'https://youtube.com/playlist?list=lHZwlzOUOZ4',
    'https://www.youtube.com/playlist?list=lHZwlzOUOZ4',

    // shorts
    'https://youtube.com/shorts/lHZwlzOUOZ4',
    'https://www.youtube.com/shorts/lHZwlzOUOZ4',
    'https://www.youtube.com/shorts/lHZwlzOUOZ4?q=some',

    // embeds
    'https://www.youtube.com/embed/lHZwlzOUOZ4',
    'https://www.youtube.com/embed/lHZwlzOUOZ4?si=MoqR8ormsErTqt6z',

    // live
    'https://youtube.com/live/lHZwlzOUOZ4',
    'https://www.youtube.com/live/lHZwlzOUOZ4',

    // shorts
//    'https://www.youtube.com/shorts/lqEDLHU-WEQ',
//    'https://youtube.com/shorts/lqEDLHU-WEQ',
//
//    // playlists
//    'https://www.youtube.com/playlist?list=PLAqhIrjkxbuWI23v9cThsA9GvCAUhRvKZ',
//    'https://youtube.com/playlist?list=PLAqhIrjkxbuWI23v9cThsA9GvCAUhRvKZ',
//
//    // embeds
//    'https://www.youtube.com/embed/lHZwlzOUOZ4?si=MoqR8ormsErTqt6z',
//

//
//    // live
//    'https://www.youtube.com/live?v=ZkqyioyUd',
//    'https://youtube.com/live?v=ZkqyioyUd',
]);
