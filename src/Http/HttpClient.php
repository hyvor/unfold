<?php

namespace Hyvor\Unfold\Http;

use Hyvor\Unfold\UnfoldConfigObject;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class HttpClient implements ClientInterface
{
    public function __construct(
        private ClientInterface $baseClient,
        private UnfoldConfigObject $config,
    ) {
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        do {
        } while (true);
    }
}
