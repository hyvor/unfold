<?php

namespace Hyvor\Unfold\Link;

use Http\Client\Common\Plugin\Journal;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class RequestRecorder implements Journal
{
    /** @var RequestInterface[] */
    private array $requests = [];

    public function addSuccess(RequestInterface $request, ResponseInterface $response): void
    {
        $this->requests[] = $request;
    }

    public function addFailure(RequestInterface $request, ClientExceptionInterface $exception): void
    {
    }

    public function getLastRequest(): ?RequestInterface
    {
        return count($this->requests) > 0 ?
            $this->requests[count($this->requests) - 1] :
            null;
    }
}
