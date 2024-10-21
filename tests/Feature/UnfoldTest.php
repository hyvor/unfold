<?php

use Hyvor\Unfold\Unfold;
use Hyvor\Unfold\UnfoldMethod;

it('gets link', function () {
    $response = Unfold::unfold('https://talk.hyvor.com');
    dd($response);
});

it('gets embed', function () {
    $response = Unfold::unfold(
        'https://www.youtube.com/watch?v=8scL5oJX6CM',
        UnfoldMethod::EMBED,
    );
    dd($response);
});
