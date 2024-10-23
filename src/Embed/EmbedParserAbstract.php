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
    protected UnfoldConfig $config;

    public function __construct(
        protected string $url,
        ?UnfoldConfig $config = null,
    ) {
        $this->config = $config ?? new UnfoldConfig();
    }


    /**
     * TODO: This is not yet used
     * If the URL needs to be replaced before sending to the oEmbed endpoint,
     * return the new URL here. Otherwise, return null
     * Ex: m.facebook.com -> www.facebook.com
     * @codeCoverageIgnore
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
            if (preg_match("~$reg~", $this->url, $matches)) {
                return $matches;
            }
        }

        return false;
    }

    /**
     * @param string[] $matches
     * @throws UnfoldException
     */
    public function parse(array $matches = null): EmbedResponseObject
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

    private function parseOEmbed(): EmbedResponseObject
    {
        /** @var self&EmbedParserOEmbedInterface $this */
        $oEmbedUrl = $this->oEmbedUrl();

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

        return EmbedResponseObject::fromArray($parsed);
    }

    /**
     * @param string[] $matches
     */
    private function parseCustom(array $matches): EmbedResponseObject
    {
        /** @var self&EmbedParserCustomInterface $this */
        $html = $this->getEmbedHtml($matches);

        return EmbedResponseObject::fromArray([
            'type' => 'embed',
            'html' => $html
        ]);
    }

}
