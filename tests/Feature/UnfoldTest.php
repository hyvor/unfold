<?php

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Hyvor\Unfold\Unfold;

it('fetches link', function () {
    $mock = new MockHandler([
        new Response(200, [], <<<HTML
<head>
    <title>HYVOR</title>
    <meta name="description" content="We craft privacy-first, user-friendly tools for websites.">
</head>
HTML
        )
    ]);

    $response = Unfold::unfold('https://hyvor.com');
});