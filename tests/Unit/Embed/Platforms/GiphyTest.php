<?php

namespace Unit\Parsers;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use Hyvor\Unfold\Embed\Platforms\Giphy;
use Hyvor\Unfold\UnfoldConfig;

it('matches tenor URLs', function (string $url) {
    $parser = new Giphy(UnfoldConfig::withUrl($url));
    $match = $parser->match();
    expect($match)->toBeArray();
})->with([
    'https://giphy.com/gifs/studiosoriginals-kindness-world-day-IwADz4opoIZthLv6Mz',
    'https://media3.giphy.com/media/v1.Y2lkPTc5MGI3NjExaGZhOGZwaTNmaHdtaGdrYjh0b3NtM2hsaXg5M2VsM250bWN4ZzZyciZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9Zw/IwADz4opoIZthLv6Mz/giphy.webp',
]);


it('fetches giphy', function () {
    $history = [];
    $historyMiddleware = Middleware::history($history);

    $mock = new MockHandler([
        new Response(200, [], json_encode([
            'html' => '<giphy></giphy>',
        ]))
    ]);

    $handlerStack = new HandlerStack($mock);
    $handlerStack->push($historyMiddleware);

    $client = new Client(['handler' => $handlerStack]);

    $url = 'https://giphy.com/gifs/studiosoriginals-kindness-world-day-IwADz4opoIZthLv6Mz';
    $config = new UnfoldConfig(httpClient: $client);
    $config->start($url);
    $parser = new Giphy($config);
    $response = $parser->parse();
    expect($response)->toBe('<giphy></giphy>');

    $request = $history[0]['request'];

    expect((string)$request->getUri())->toBe(
        'https://giphy.com/services/oembed?url=' . $url . '&format=json'
    );
});
