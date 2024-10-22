<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Hyvor\Unfold\Exception\LinkScrapeException;
use Hyvor\Unfold\Unfold;
use Hyvor\Unfold\UnfoldConfig;

it('fetches link success', function () {
    $mock = new MockHandler([
        new Response(200, [], <<<HTML
<html lang="fr">
<head>
    <title>HYVOR</title>
    <meta name="description" content="We craft privacy-first, user-friendly tools for websites.">
    
    <meta name="og:url" content="https://hyvor.com">
    <meta name="og:image" content="https://hyvor.com/image.jpg">
    <meta name="article:published_time" content="2021-09-01T00:00:00+00:00">
    <meta name="article:modified_time" content="2021-09-02T00:00:00+00:00">
    <meta name="article:tag" content="php">
    
    <meta name="twitter:site" content="HYVOR WEBSITE">
    <link rel="canonical" href="https://hyvor.com">
    <link rel="icon" href="https://hyvor.com/favicon.ico">
    
    <script type="application/ld+json">
    {
        "author": [
            {
                "name": "John Doe",
                "url": "https://johndoe.com"
            }
        ]
    }
    </script>
</head>
</html>
HTML
        )
    ]);
    $client = new Client(['handler' => $mock]);

    $response = Unfold::unfold(
        'https://hyvor.com',
        config: new UnfoldConfig(
            httpClient: $client
        )
    );

    expect($response->title)->toBe('HYVOR');
    expect($response->description)->toBe('We craft privacy-first, user-friendly tools for websites.');
    expect($response->publishedTime->format('Y-m-d'))->toBe('2021-09-01');
    expect($response->modifiedTime->format('Y-m-d'))->toBe('2021-09-02');
    expect($response->siteName)->toBe('HYVOR WEBSITE');
    expect($response->siteUrl)->toBe('https://hyvor.com');
    expect($response->canonicalUrl)->toBe('https://hyvor.com');

    expect($response->authors)->toHaveCount(1);
    expect($response->authors[0]->name)->toBe('John Doe');
    expect($response->authors[0]->url)->toBe('https://johndoe.com');

    expect($response->tags)->toHaveCount(1);
    expect($response->tags[0]->name)->toBe('php');

    expect($response->thumbnailUrl)->toBe('https://hyvor.com/image.jpg');
    expect($response->iconUrl)->toBe('https://hyvor.com/favicon.ico');
    expect($response->locale)->toBe('fr');
});

it('on 404', function () {
    $mock = new MockHandler([
        new Response(404)
    ]);
    $client = new Client(['handler' => $mock]);

    expect(fn() => Unfold::unfold(
        'https://hyvor.com',
        config: new UnfoldConfig(
            httpClient: $client
        )
    ))->toThrow(
        LinkScrapeException::class,
        'Unable to scrape link. HTTP status code: 404'
    );
});

it('request exception', function () {
    $mock = new MockHandler([
        new RequestException(
            'Error Communicating with Server',
            new Request('GET', 'test')
        )
    ]);
    $client = new Client(['handler' => $mock]);

    expect(fn() => Unfold::unfold(
        'https://hyvor.com',
        config: new UnfoldConfig(
            httpClient: $client
        )
    ))->toThrow(
        LinkScrapeException::class,
        'Error Communicating with Server'
    );
});