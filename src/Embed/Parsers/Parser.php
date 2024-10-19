<?php

namespace Hyvor\Unfold\Embed\Parsers;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use Hyvor\Unfold\Types\UnfoldConfig;

/**
 * Parser is used to match a URL with a regex pattern and get embed HTML code
 * Optionally, it would return metadata as well
 */
abstract class Parser
{

    private UnfoldConfig $config;

    public function __construct(
        private string $url,
        ?UnfoldConfig $config = null,
    ) {
        $this->config = $config ?? new UnfoldConfig();
    }

    /**
     * PCRE regex patterns to match the URL
     * @return string[]
     */
    abstract protected function regex();

    abstract protected function oEmbedUrl(): ?string;

    public function match()
    {
        // TODO;
    }

    public function parse() : ?array
    {

        $oEmbedUrl = $this->oEmbedUrl();

        if (!$oEmbedUrl) {
            return null;
        }


        $uri = Uri::withQueryValues(
            new Uri($this->oEmbedUrl()),
            [
                'url' => $this->url,
                'format' => 'json'
            ]
        );

        $request = new Request(
            'GET',
            $uri,
            [
                'Accept' => 'application/json',
            ],
        );

        $client = $this->config->httpClient;
        $response = $client->sendRequest($request);

        return json_decode($response->getBody()->getContents(), true);
    }

}