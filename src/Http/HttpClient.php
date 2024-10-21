<?php

namespace Hyvor\Unfold\Http;

use GuzzleHttp\Psr7\Exception\MalformedUriException;
use GuzzleHttp\Psr7\Uri;
use Hyvor\Unfold\UnfoldConfigObject;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class HttpClient implements ClientInterface
{
    public function __construct(
        private UnfoldConfigObject $config,
    ) {
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $counter = 1;
        do {
            $response = $this->config->httpClient->sendRequest($request);
            $redirectUri = $this->checkRedirect($response);

            if ($redirectUri) {
                $request = $request->withUri($redirectUri);
                $counter++;
            } else {
                return $response;
            }
        } while ($counter <= $this->config->httpMaxRedirects);

        return $response;
    }

    private function checkRedirect(
        ResponseInterface $response
    ): ?Uri {
        $status = $response->getStatusCode();

        if ($status < 300 || $status >= 400) {
            return null;
        }

        if (!$response->hasHeader('Location')) {
            return null;
        }

        $location = $response->getHeader('Location')[0] ?? null;

        if (!$location) {
            return null;
        }

        try {
            return new Uri($location);
        } catch (MalformedUriException) {
            return null;
        }
    }
}
