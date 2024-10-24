<?php

namespace Hyvor\Unfold\Link;

use GuzzleHttp\Psr7\Request;
use Hyvor\Unfold\Exception\LinkScrapeException;
use Hyvor\Unfold\Link\Metadata\MetadataParser;
use Hyvor\Unfold\UnfoldConfig;
use Hyvor\Unfold\Unfolded\Unfolded;
use Hyvor\Unfold\UnfoldCallContext;
use Psr\Http\Client\ClientExceptionInterface;

class Link
{
    public function __construct(
        private string $url,
        private UnfoldConfig $config,
    ) {
    }

    public function scrape(): string
    {
        $request = new Request(
            'GET',
            $this->url
        );

        try {
            $response = $this->config->httpClient->sendRequest($request);
        } catch (ClientExceptionInterface $e) {
            throw new LinkScrapeException($e->getMessage());
        }

        $status = $response->getStatusCode();

        if ($status < 200 || $status >= 300) {
            throw new LinkScrapeException("Unable to scrape link. HTTP status code: $status");
        }

        $lastRequest = $this->config->httpClient->getLastRequest();

        return $response->getBody()->getContents();
    }


    public static function getUnfoldedObject(
        string $url,
        UnfoldCallContext $context,
    ): Unfolded {
        $content = (new Link($url, $context->config))->scrape();
        $metadata = (new MetadataParser($content))->parse();

        return Unfolded::fromMetadata(
            $url,
            $metadata,
            $context,
        );
    }
}
