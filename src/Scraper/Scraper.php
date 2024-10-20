<?php

namespace Hyvor\Unfold\Scraper;

use GuzzleHttp\Psr7\Request;
use Hyvor\Unfold\MetadataParsers\MetadataParser;
use Hyvor\Unfold\Objects\UnfoldedObject;
use Hyvor\Unfold\UnfoldConfigObject;
use Hyvor\Unfold\UnfoldMethodEnum;
use Psr\Http\Client\ClientExceptionInterface;

class Scraper
{
    public function __construct(
        private string $url,
        private UnfoldConfigObject $config,
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
            //
        }

        $status = $response->getStatusCode();
        $content = $response->getBody()->getContents();

        return $response->getBody();
    }


    public static function getUnfoldedObject(
        string $url,
        UnfoldMethodEnum $method,
        UnfoldConfigObject $config,
        float $startTime
    ): UnfoldedObject {
        $content = (new Scraper($url, $config))->scrape();
        $metadata = (new MetadataParser($content))->parse();

        return UnfoldedObject::fromMetadata(
            $method,
            $url,
            $metadata,
            $startTime
        );
    }
}
