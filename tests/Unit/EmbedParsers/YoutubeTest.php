<?php

namespace Unit\Parsers;

use Hyvor\Unfold\Embed\EmbedParsers\Platforms\Youtube;

it('configs', function () {
    $youtube = new Youtube('https://www.youtube.com/watch?v=X-sZhiYAz');
    expect($youtube->oEmbedUrl())->toBe('https://www.youtube.com/oembed');
});

it('matches youtube URLs', function (string $url) {
    $parser = new Youtube($url);
    $match = $parser->match();
    expect($match)->toBeTrue();
})->with([

    // videos
    'https://www.youtube.com/watch?v=X-sZhiYAz',
    'https://www.youtube.com/watch?v=lHZwlzOUOZ4',

    // shorts
    'https://www.youtube.com/shorts/lqEDLHU-WEQ',
    'https://youtube.com/shorts/lqEDLHU-WEQ',

    // playlists
    'https://www.youtube.com/playlist?list=PLAqhIrjkxbuWI23v9cThsA9GvCAUhRvKZ',
    'https://youtube.com/playlist?list=PLAqhIrjkxbuWI23v9cThsA9GvCAUhRvKZ',

    // embeds
    'https://www.youtube.com/embed/lHZwlzOUOZ4?si=MoqR8ormsErTqt6z',

    // youtu.be
    'https://youtu.be/lHZwlzOUOZ4?si=q75TsgT5bAs9VLZn',

    // live
    'https://www.youtube.com/live?v=ZkqyioyUd',
    'https://youtube.com/live?v=ZkqyioyUd',
]);
