<?php

namespace Hyvor\Unfold\Embed\EmbedParsers;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use Hyvor\Unfold\Embed\EmbedParsers\Exception\ParserException;
use Hyvor\Unfold\Types\UnfoldConfig;
use Psr\Http\Client\ClientExceptionInterface;

/**
 * EmbedParserAbstract is used to match a URL with a regex pattern and get embed HTML code
 * Optionally, it would return metadata as well
 */
abstract class EmbedParserAbstract
{
    private UnfoldConfig $config;

    public function __construct(
        private string $url,
        ?UnfoldConfig $config = null,
    ) {
        $this->config = $config ?? new UnfoldConfig();
    }


    /**
     * TODO: This is not yet used
     * If the URL needs to be replaced before sending to the oEmbed endpoint,
     * return the new URL here. Otherwise, return null
     * Ex: m.facebook.com -> www.facebook.com
     */
    public function replaceUrl(): ?string
    {
        return null;
    }


    /**
     * PCRE regex patterns to match the URL
     * Delimiter should not be added. ~ will be added automatically
     * / is safe to use without escaping
     * @return string[]
     */
    abstract public function oEmbedRegex();

    abstract public function oEmbedUrl(): ?string;

    public function match(): bool
    {
        $regex = $this->oEmbedRegex();

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
