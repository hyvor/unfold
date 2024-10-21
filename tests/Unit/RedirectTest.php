<?php

namespace Hyvor\Unfold\Tests\Unit;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use Hyvor\Unfold\UnfoldConfigObject;

it('uri', function () {
    $request = new Request('GET', 'http://talk.hyvor.com');
    $request = $request->withUri(new Uri('/embed'));
    var_dump($request->getUri());
    expect(true)->toBeTrue();
});

it('redirects', function () {
    $config = new UnfoldConfigObject();

    $request = new Request(
        'GET',
        'http://talk.hyvor.com'
    );

    $response = $config->httpClient->sendRequest($request);
    dd($response);
});
