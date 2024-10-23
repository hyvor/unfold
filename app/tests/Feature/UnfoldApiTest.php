<?php

namespace Tests\Feature;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

it('returns Unfold response for link', function () {

    $mock = new MockHandler([
        new Response(200, [],
            '<html lang="en" dir="ltr"><head><title>Google Cloud Platform (GCP): Setting up a GPU-Based Virtual Machine (VM) with Jupyter Notebook for LLMs</title><meta name="description" content="A descriptive guide on how to setup a gpu based vm in google cloud platform" /><link rel="canonical" href="https://nadil.me/google-cloud-platform" />
<link rel="shortcut icon" href="https://nadil.me/media/xVlcRFxJXtxHmytQ.png" /><meta property="og:site_name" content="Nadil&#039;s Blog" /><meta property="og:type" content="article" /><meta property="og:title" content="Google Cloud Platform (GCP): Setting up a GPU-Based Virtual Machine (VM) with Jupyter Notebook for LLMs" />
<meta property="og:locale" content="en" /><meta property="og:description" content="A descriptive guide on how to setup a gpu based vm in google cloud platform" /><meta property="og:url" content="https://nadil.me/google-cloud-platform" /><meta property="og:image" content="" />
<meta property="article:published_time" content="2024-06-23T14:16:22+00:00" /><meta property="article:modified_time" content="2024-10-22T13:26:08+00:00" /><meta property="article:author" content="Nadil Karunarathna" />
<meta name="twitter:card" content="summary_large_image" /><meta name="twitter:title" content="Google Cloud Platform (GCP): Setting up a GPU-Based Virtual Machine (VM) with Jupyter Notebook for LLMs" /><meta name="twitter:description" content="A descriptive guide on how to setup a gpu based vm in google cloud platform" />
<meta name="twitter:url" content="https://nadil.me/google-cloud-platform" /><meta name="twitter:image" content="" /><meta name="twitter:site" content="@nadil_k" /></head><html>'
        ),
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack]);

    app()->bind('httpClient', function () use ($client) {
        return $client;
    });

    $response = $this->getJson('/unfold?'.http_build_query([
        'url' => 'https://nadil.me/google-cloud-platform',
    ]));

    $response->assertStatus(200);
    $response->assertJsonFragment([
        'version' => '1.0',
        'method' => 'link',
        'url' => 'https://nadil.me/google-cloud-platform',
        'embed' => null,
        'title' => 'Google Cloud Platform (GCP): Setting up a GPU-Based Virtual Machine (VM) with Jupyter Notebook for LLMs',
        'description' => 'A descriptive guide on how to setup a gpu based vm in google cloud platform',
        'authors' => [
            [
                'name' => 'Nadil Karunarathna',
                'url' => null,
            ],
        ],
        'tags' => [],
        'siteName' => "Nadil's Blog",
        'siteUrl' => 'https://nadil.me',
        'canonicalUrl' => 'https://nadil.me/google-cloud-platform',
        'publishedTime' => [
            'date' => '2024-06-23 14:16:22.000000',
            'timezone_type' => 1,
            'timezone' => '+00:00',
        ],
        'modifiedTime' => [
            'date' => '2024-10-22 13:26:08.000000',
            'timezone_type' => 1,
            'timezone' => '+00:00',
        ],
        'thumbnailUrl' => null,
        'iconUrl' => null,
        'locale' => 'en',
    ]);
});

it('returns Unfold response for embed', function () {
    $mock = new MockHandler([
        new Response(200, [], json_encode([
            'title' => 'Lana Del Rey - Born To Die',
            'author_name' => 'LanaDelReyVEVO',
            'author_url' => 'https://www.youtube.com/@LanaDelReyVEVO',
            'type' => 'video',
            'height' => 113,
            'width' => 200,
            'version' => '1.0',
            'provider_name' => 'YouTube',
            'provider_url' => 'https://www.youtube.com/',
            'thumbnail_height' => 360,
            'thumbnail_width' => 480,
            'thumbnail_url' => 'https://i.ytimg.com/vi/Bag1gUxuU0g/hqdefault.jpg',
            'html' => '<iframe width="200" height="113" src="https://www.youtube.com/embed/Bag1gUxuU0g?feature=oembed" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen title="Lana Del Rey - Born To Die"></iframe>',
        ])
        ),
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack]);

    app()->bind('httpClient', function () use ($client) {
        return $client;
    });

    $response = $this->getJson('/unfold?'.http_build_query([
        'url' => 'https://www.youtube.com/watch?v=Bag1gUxuU0g',
        'method' => 'embed',
    ]));

    $response->assertStatus(200);
    $response->assertJsonFragment([
        'version' => '1.0',
        'method' => 'embed',
        'url' => 'https://www.youtube.com/watch?v=Bag1gUxuU0g',
        'embed' => '<iframe width="200" height="113" src="https://www.youtube.com/embed/Bag1gUxuU0g?feature=oembed" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen title="Lana Del Rey - Born To Die"></iframe>',
        'title' => 'Lana Del Rey - Born To Die',
        'description' => null,
        'authors' => [
            [
                'name' => 'LanaDelReyVEVO',
                'url' => 'https://www.youtube.com/@LanaDelReyVEVO',
            ],
        ],
        'tags' => [],
        'siteName' => 'YouTube',
        'siteUrl' => 'https://www.youtube.com/',
        'canonicalUrl' => null,
        'publishedTime' => null,
        'modifiedTime' => null,
        'thumbnailUrl' => 'https://i.ytimg.com/vi/Bag1gUxuU0g/hqdefault.jpg',
        'iconUrl' => null,
        'locale' => null,
    ]);
});
