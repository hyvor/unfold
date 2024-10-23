<?php

use Hyvor\Unfold\Embed\Embed;
use Hyvor\Unfold\Embed\Platforms\FacebookPage;
use Hyvor\Unfold\Embed\Platforms\FacebookPost;

it('gets parsers with correct sort', function () {
    $parsers = Embed::getParsers();

    $fbPost = array_search(FacebookPost::class, $parsers);
    $fbPage = array_search(FacebookPage::class, $parsers);

    expect($fbPost < $fbPage)->toBeTrue();
});
