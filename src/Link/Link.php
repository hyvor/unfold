<?php

namespace Hyvor\Unfold\Link;

use GuzzleHttp\Psr7\Request;
use Hyvor\Unfold\Link\MetadataParsers\MetadataParser;
use Hyvor\Unfold\Objects\UnfoldedObject;
use Hyvor\Unfold\Objects\UnfoldRequestContextObject;
use Hyvor\Unfold\UnfoldConfigObject;
use Psr\Http\Client\ClientExceptionInterface;

class Link
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
        // TODO:

        return $response->getBody();
    }


    public static function getUnfoldedObject(
        string $url,
        UnfoldRequestContextObject $context,
    ): UnfoldedObject {
        $content = (new Link($url, $context->config))->scrape();
        $metadata = (new MetadataParser($content))->parse();

        return UnfoldedObject::fromMetadata(
            $url,
            $metadata,
            $context,
        );
    }
}
