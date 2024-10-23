<?php

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use Hyvor\Unfold\Exception\EmbedUnableToResolveException;
use Hyvor\Unfold\Unfold;
use Hyvor\Unfold\UnfoldConfig;
use Hyvor\Unfold\UnfoldMethod;

it('fetches embed success', function () {
    $history = [];
    $historyMiddleware = Middleware::history($history);

    $mock = new MockHandler([
        new Response(200, [], json_encode([
            // oembed response
            'version' => '1.0',
            'type' => 'video',
            'provider_name' => 'YouTube',
            'provider_url' => 'https://youtube.com/',
            'width' => 425,
            'height' => 344,
            'title' => 'Amazing Nintendo Facts',
            'author_name' => 'ZackScott',
            'author_url' => 'https://www.youtube.com/user/ZackScott',
            'html' => '<my-youtube-video></my-youtube-video>',
        ]))
    ]);

    $stack = HandlerStack::create($mock);
    $stack->push($historyMiddleware);
    $client = new Client(['handler' => $stack]);
    $response = Unfold::unfold(
        'https://www.youtube.com/watch?v=123',
        method: UnfoldMethod::EMBED,
        config: new UnfoldConfig(
            httpClient: $client
        )
    );

    expect($response->version)->toBe('1.0');
    expect($response->url)->toBe('https://www.youtube.com/watch?v=123');
    expect($response->embed)->toBe('<my-youtube-video></my-youtube-video>');
    expect($response->title)->toBe('Amazing Nintendo Facts');

    expect($response->authors)->toHaveCount(1);
    expect($response->authors[0]->name)->toBe('ZackScott');
    expect($response->authors[0]->url)->toBe('https://www.youtube.com/user/ZackScott');

    $request = $history[0]['request'];
    expect($request->getMethod())->toBe('GET');
    expect((string)$request->getUri())
        ->toBe('https://www.youtube.com/oembed?url=https://www.youtube.com/watch?v%3D123&format=json');
})->skip(); // TODO: Skipped for now until final custom/oembed providers are decided

it('fetches custom', function () {
    $response = Unfold::unfold(
        'https://gist.github.com/123',
        method: UnfoldMethod::EMBED,
    );
    expect($response->embed)->toBe('<script src="https://gist.github.com/123.js"></script>');
});

it('on unable to resolve', function () {
    expect(fn () => Unfold::unfold(
        'https://hyvor.com',
        method: UnfoldMethod::EMBED,
        config: new UnfoldConfig()
    ))->toThrow(EmbedUnableToResolveException::class);
});
