<?php

namespace Hyvor\Unfold\Link;

use Http\Client\Common\Plugin\Journal;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class LastRequestRecorder implements Journal
{

    private RequestInterface $request;

    public function addSuccess(RequestInterface $request, ResponseInterface $response): void
    {
        $this->request = $request;
    }

    public function addFailure(RequestInterface $request, ClientExceptionInterface $exception): void
    {
    }

    public function getLastRequest(): RequestInterface
    {
        return $this->request;
    }
}