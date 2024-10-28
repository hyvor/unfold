<?php

namespace Hyvor\Unfold\Embed;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use Hyvor\Unfold\Exception\EmbedParserException;
use Hyvor\Unfold\Exception\UnfoldException;
use Hyvor\Unfold\UnfoldConfig;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\RequestInterface;

/**
 * EmbedParserAbstract is used to match a URL with a regex pattern and get embed HTML code
 * Optionally, it would return metadata as well
 */
abstract class EmbedParserAbstract
{
    // define priority relatively
    public const PRIORITY = 0;

    public function __construct(protected UnfoldConfig $config)
    {
    }

    /**
     * PCRE regex patterns to match the URL
     * Delimiter should not be added. ~ will be added automatically
     * / is safe to use without escaping
     * @return string[]
     */
    abstract public function regex();

    /**
     * If the request needs to be modified before sending to the oEmbed endpoint,
     */
    public function oEmbedRequestFilter(RequestInterface $request): RequestInterface
    {
        return $request;
    }

    /**
     * @return false|string[]
     */
    public function match(): false|array
    {
        $regex = $this->regex();

        foreach ($regex as $reg) {
            if (preg_match("~$reg~", $this->config->url, $matches)) {
                return $matches;
            }
        }

        return false;
    }

    /**
     * @param string[] $matches
     * @throws UnfoldException
     */
    public function parse(array $matches = null): string
    {
        $matches ??= $this->match();

        if ($matches === false) {
            // null default for $matches is only to make testing easy
            // so this should not happen outside tests
            throw new EmbedParserException("URL does not match any of the patterns");
        }

        if ($this instanceof EmbedParserOEmbedInterface) {
            return $this->parseOEmbed();
        } elseif ($this instanceof EmbedParserCustomInterface) {
            return $this->parseCustom($matches);
        } else {
            // @codeCoverageIgnoreStart
            throw new \Exception(
                'EmbedParserAbstract should be implemented with either EmbedParserOEmbedInterface or EmbedParserCustomInterface'
            );
            // @codeCoverageIgnoreEnd
        }
    }

    private function parseOEmbed(): string
    {
        /** @var self&EmbedParserOEmbedInterface $this */
        $oEmbedUrl = $this->oEmbedUrl();

        $uri = Uri::withQueryValues(
            new Uri($oEmbedUrl),
            [
                'url' => $this->config->url,
                'format' => 'json'
            ]
        );

        $request = new Request(
            'GET',
            $uri,
            [
                'Accept' => 'application/json',
                'User-Agent' => $this->config->httpUserAgent,
            ],
        );

        $request = $this->oEmbedRequestFilter($request);

        $client = $this->config->httpClient;
        try {
            $response = $client->sendRequest($request);
        } catch (ClientExceptionInterface $e) {
            throw new EmbedParserException(
                "Failed to fetch oEmbed data from the endpoint",
                previous: $e
            );
        }

        $status = $response->getStatusCode();
        $content = $response->getBody()->getContents();

        if ($status !== 200) {
            throw new EmbedParserException(
                "Failed to fetch oEmbed data from the endpoint. Status: $status. Response: $content"
            );
        }

        $parsed = json_decode($content, true);

        if (!is_array($parsed)) {
            throw new EmbedParserException("Failed to parse JSON response from oEmbed endpoint");
        }

        $html = $parsed['html'];

        if (!is_string($html) || empty($html)) {
            throw new EmbedParserException("Failed to get HTML from oEmbed endpoint");
        }

        return $html;
    }

    /**
     * @param string[] $matches
     */
    private function parseCustom(array $matches): string
    {
        /** @var self&EmbedParserCustomInterface $this */
        return $this->getEmbedHtml($matches);
    }

}
