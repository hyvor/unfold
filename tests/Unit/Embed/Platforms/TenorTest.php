<?php

namespace Unit\Parsers;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use Hyvor\Unfold\Embed\Platforms\Tenor;
use Hyvor\Unfold\UnfoldConfig;

it('matches tenor URLs', function (string $url) {
    $parser = new Tenor(UnfoldConfig::withUrl($url));
    $match = $parser->match();
    expect($match)->toBeArray();
})->with([
    'https://tenor.com/view/shannon-sharpe-shannon-sharpe-drinking-fox-undisputed-skip-bayless-gif-23482018',
    'https://tenor.com/view/steph-curry-stephen-curry-chef-curry-curry-warriors-gif-2893813801205262964'
]);

it('fetches tenor', function () {
    $history = [];
    $historyMiddleware = Middleware::history($history);

    $mock = new MockHandler([
        new Response(200, [], json_encode([
            'html' => '<tenor></tenor>',
        ]))
    ]);

    $handlerStack = new HandlerStack($mock);
    $handlerStack->push($historyMiddleware);
    $client = new Client(['handler' => $handlerStack]);

    $url = 'https://tenor.com/view/shannon-sharpe-shannon-sharpe-drinking-fox-undisputed-skip-bayless-gif-23482018';
    $config = new UnfoldConfig(httpClient: $client);
    $config->start($url);
    $parser = new Tenor($config);
    $response = $parser->parse();
    expect($response)->toBe('<tenor></tenor>');

    $request = $history[0]['request'];

    expect((string)$request->getUri())->toBe(
        'https://tenor.com/oembed?url=' . $url . '&format=json'
    );
});