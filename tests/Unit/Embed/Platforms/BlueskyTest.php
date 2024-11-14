<?php

namespace Unit\Parsers;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Hyvor\Unfold\Embed\Platforms\Bluesky;
use Hyvor\Unfold\UnfoldConfig;

it('fetches bluesky', function () {
    $mock = new MockHandler([
        new Response(200, [], json_encode([
            'html' => '<bluesky-embed></bluesky-embed>',
        ]))
    ]);
    $client = new Client(['handler' => $mock]);

    $url = 'https://bsky.app/profile/jwstfeed.bsky.social/post/3lau5ohfxcc2t';
    $config = new UnfoldConfig(httpClient: $client);
    $config->start($url);
    $parser = new Bluesky($config);
    $response = $parser->parse();
    expect($response)->toBe('<bluesky-embed></bluesky-embed>');
});