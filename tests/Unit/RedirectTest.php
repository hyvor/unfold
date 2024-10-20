<?php

namespace Hyvor\Unfold\Tests\Unit;

use GuzzleHttp\Psr7\Request;
use Hyvor\Unfold\UnfoldConfigObject;

it('redirects', function () {
    $config = new UnfoldConfigObject();

    $request = new Request(
        'GET',
        'http://talk.hyvor.com'
    );

    $response = $config->httpClient->sendRequest($request);
    dd($response);
});
