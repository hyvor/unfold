<?php

namespace Hyvor\Unfold\Link;

use GuzzleHttp\Psr7\Request;
use Http\Client\Common\Exception\LoopException;
use Hyvor\Unfold\Exception\LinkScrapeException;
use Hyvor\Unfold\Link\Metadata\MetadataParser;
use Hyvor\Unfold\UnfoldConfig;
use Hyvor\Unfold\Unfolded\Unfolded;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\RequestInterface;

class Link
{

    private ?RequestInterface $lastRequest = null;

    public function __construct(
        private UnfoldConfig $config,
    ) {
    }

    public function scrape(): string
    {
        $request = new Request(
            'GET',
            $this->config->url
        );

        try {
            $response = $this->config->httpClient->sendRequest($request);
        } catch (ClientExceptionInterface $e) {
            $message = match (true) {
                $e instanceof LoopException => 'Too many redirects',
                default => $e->getMessage(),
            };
            throw new LinkScrapeException($message);
        }

        $status = $response->getStatusCode();

        if ($status < 200 || $status >= 300) {
            throw new LinkScrapeException("Unable to scrape link. HTTP status code: $status");
        }

        $this->lastRequest = $this->config->httpRequestRecorder->getLastRequest();

        return $response->getBody()->getContents();
    }

    public static function getUnfoldedObject(
        UnfoldConfig $config,
    ): Unfolded {
        $link = new Link($config);
        $content = $link->scrape();
        $lastRequest = $link->lastRequest;

        $metadata = (new MetadataParser($content, $config))->parse();

        return Unfolded::fromMetadata(
            $config,
            $metadata,
            $lastRequest,
        );
    }
}
