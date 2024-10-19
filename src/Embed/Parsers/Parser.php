<?php

namespace Hyvor\Unfold\Embed\Parsers;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use Hyvor\Unfold\Embed\Parsers\Exception\ParserException;
use Hyvor\Unfold\UnfoldConfig;
use Psr\Http\Client\ClientExceptionInterface;

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
     * Delimiter should not be added. ~ will be added automatically
     * / is safe to use without escaping
     * @return string[]
     */
    abstract public function regex();

    abstract public function oEmbedUrl(): ?string;

    public function match(): bool
    {
        $regex = $this->regex();

        foreach ($regex as $reg) {
            if (preg_match("~$reg~", $this->url)) {
                return true;
            }
        }

        return false;
    }

    public function parse(): ?OEmbedResponse
    {
        $oEmbedUrl = $this->oEmbedUrl();

        if (!$oEmbedUrl) {
            // TODO: Check config option for fallback
            return null;
        }

        $uri = Uri::withQueryValues(
            new Uri($oEmbedUrl),
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
        try {
            $response = $client->sendRequest($request);
        } catch (ClientExceptionInterface $e) {
            throw new ParserException(
                "Failed to fetch oEmbed data from the endpoint",
                0,
                $e
            );
        }

        $status = $response->getStatusCode();
        $content = $response->getBody()->getContents();

        if ($status !== 200) {
            throw new ParserException(
                "Failed to fetch oEmbed data from the endpoint. Status: $status. Response: $content"
            );
        }

        $parsed = json_decode($content, true);

        if (!is_array($parsed)) {
            throw new ParserException("Failed to parse JSON response from oEmbed endpoint");
        }

        return OEmbedResponse::fromArray($parsed);
    }

}
