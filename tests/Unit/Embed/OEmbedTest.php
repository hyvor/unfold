<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Hyvor\Unfold\Embed\EmbedParserAbstract;
use Hyvor\Unfold\Embed\EmbedParserOEmbedInterface;
use Hyvor\Unfold\Exception\EmbedParserException;
use Hyvor\Unfold\UnfoldConfig;

class OEmbedTestPlatform extends EmbedParserAbstract implements EmbedParserOEmbedInterface
{
    public function regex()
    {
        return [
            'https://hyvor.com/.*'
        ];
    }

    public function oEmbedUrl(): string
    {
        return 'https://oembed.hyvor.com';
    }
}

it('not matching', function () {
    $platform = new OEmbedTestPlatform(UnfoldConfig::withUrl('https://example.com'));
    expect($platform->match())->toBeFalse();
});

it('valid response', function () {
    $history = [];
    $historyMiddleware = Middleware::history($history);

    $mock = new MockHandler([
        new Response(200, [], json_encode([
            'title' => 'Hello, World!',
            'author_name' => 'HYVOR',
            'author_url' => 'https://hyvor.com',
            'type' => 'rich',
            'html' => '<iframe src="https://hyvor.com/embed/123"></iframe>',
            'width' => 500,
            'height' => 500,
            'thumbnail_url' => 'https://hyvor.com/thumbnail.png',
            'thumbnail_width' => 100,
            'thumbnail_height' => 100,
            'provider_name' => 'HYVOR',
            'provider_url' => 'https://hyvor.com',
            'version' => '1.0'
        ]))
    ]);

    $handlerStack = new HandlerStack($mock);
    $handlerStack->push($historyMiddleware);
    $client = new Client(['handler' => $handlerStack]);

    $platform = new OEmbedTestPlatform(
        (new UnfoldConfig(
            httpClient: $client
        ))->start('https://hyvor.com/123')
    );

    $response = $platform->parse();

//    expect($response->version)->toBe('1.0');
//    expect($response->title)->toBe('Hello, World!');
//    expect($response->author_name)->toBe('HYVOR');
//    expect($response->author_url)->toBe('https://hyvor.com');
//    expect($response->type)->toBe(OEmbedTypeEnum::RICH);
    expect($response)->toBe('<iframe src="https://hyvor.com/embed/123"></iframe>');
//    expect($response->width)->toBe(500);
//    expect($response->height)->toBe(500);
//    expect($response->thumbnail_url)->toBe('https://hyvor.com/thumbnail.png');
//    expect($response->thumbnail_width)->toBe(100);
//    expect($response->thumbnail_height)->toBe(100);
//    expect($response->provider_name)->toBe('HYVOR');
//    expect($response->provider_url)->toBe('https://hyvor.com');

    $request = $history[0]['request'];
    expect($request->getMethod())->toBe('GET');
    expect((string)$request->getUri())
        ->toBe('https://oembed.hyvor.com?url=https://hyvor.com/123&format=json');

    $headers = $request->getHeaders();
    expect($headers['Accept'][0])->toBe('application/json');
    expect($headers['User-Agent'][0])->toBe('Hyvor Unfold PHP Client');
});


it('redirects', function () {
    $mock = new MockHandler([
        new Response(
            301,
            [
                'Location' => 'https://oembed.hyvor.com/redirected'
            ],
            null,
            '1.1',
            'Moved Permanently'
        ),
        new Response(200, [], json_encode([
            'title' => 'Hello, World!',
            'type' => 'rich',
            'html' => '<iframe src="https://hyvor.com/embed/123"></iframe>',
        ]))
    ]);

    $handlerStack = new HandlerStack($mock);
    $client = new Client(['handler' => $handlerStack]);

    $platform = new OEmbedTestPlatform(
        (new UnfoldConfig(
            httpClient: $client
        ))->start('https://hyvor.com/123')
    );

    $response = $platform->parse();

    // expect($response->title)->toBe('Hello, World!');
    // expect($response->type)->toBe(OEmbedTypeEnum::RICH);
    expect($response)->toBe('<iframe src="https://hyvor.com/embed/123"></iframe>');

    $request = $mock->getLastRequest();
    expect((string)$request->getUri())
        ->toBe('https://oembed.hyvor.com/redirected');
});

it('client exception', function () {
    $mock = new MockHandler([
        new RequestException('Failed to connect', new Request('GET', '/test'))
    ]);

    $handlerStack = new HandlerStack($mock);
    $client = new Client(['handler' => $handlerStack]);

    $platform = new OEmbedTestPlatform(
        (new UnfoldConfig(
            httpClient: $client
        ))->start('https://hyvor.com/123')
    );

    $exception = null;
    try {
        $platform->parse();
    } catch (Exception $e) {
        $exception = $e;
    }

    expect($exception)->toBeInstanceOf(EmbedParserException::class);
    expect($exception->getMessage())->toBe('Failed to fetch oEmbed data from the endpoint');
});

it('non-200 status code exception', function () {
    $mock = new MockHandler([
        new Response(404)
    ]);

    $handlerStack = new HandlerStack($mock);
    $client = new Client(['handler' => $handlerStack]);

    $platform = new OEmbedTestPlatform(
        (new UnfoldConfig(
            httpClient: $client
        ))->start('https://hyvor.com/123')
    );

    $exception = null;
    try {
        $platform->parse();
    } catch (Exception $e) {
        $exception = $e;
    }

    expect($exception)->toBeInstanceOf(EmbedParserException::class);
    expect($exception->getMessage())->toBe('Failed to fetch oEmbed data from the endpoint. Status: 404. Response: ');
});

it('json decode exception', function () {
    $mock = new MockHandler([
        new Response(200, [], 'invalid json')
    ]);

    $handlerStack = new HandlerStack($mock);
    $client = new Client(['handler' => $handlerStack]);

    $platform = new OEmbedTestPlatform(
        (new UnfoldConfig(
            httpClient: $client
        ))->start('https://hyvor.com/123')
    );

    $exception = null;
    try {
        $platform->parse();
    } catch (Exception $e) {
        $exception = $e;
    }

    expect($exception)->toBeInstanceOf(EmbedParserException::class);
    expect($exception->getMessage())->toBe('Failed to parse JSON response from oEmbed endpoint');
});
