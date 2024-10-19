<?php

namespace Hyvor\Unfold\Parsers;

use GuzzleHttp\Client;
use Psr\Http\Client\ClientInterface;

/**
 * Parser is used to match a URL with a regex pattern and get embed HTML code
 * Optionally, it would return metadata as well
 */
abstract class Parser
{

    public function __construct(
        private string $url,
    ) {}

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

    public function parse()
    {
        $client = new Client();

        $response = $client->get($this->oEmbedUrl(), [
            'query' => [
                'url' => $this->url,
                'format' => 'json'
            ]
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

}