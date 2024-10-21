<?php

namespace Hyvor\Unfold\EmbedParsers\Platforms;

use GuzzleHttp\Psr7\Uri;
use Hyvor\Unfold\EmbedParsers\EmbedParserAbstract;
use Hyvor\Unfold\EmbedParsers\EmbedParserOEmbedInterface;
use Hyvor\Unfold\EmbedParsers\Exception\ParserException;
use Psr\Http\Message\RequestInterface;

// TODO:
class Instagram extends EmbedParserAbstract implements EmbedParserOEmbedInterface
{
    public function oEmbedRequestFilter(RequestInterface $request): RequestInterface
    {
        $uri = $request->getUri();
        $facebookAccessToken = $this->config->facebookAccessToken;

        if (!$facebookAccessToken) {
            throw new ParserException('Facebook Access Token is required for Instagram embeds');
        }

        $uri = Uri::withQueryValue($uri, 'access_token', $facebookAccessToken);

        return $request->withUri($uri);
    }

    public function regex()
    {
        return [
            "http://instagram.com/.*/p/.*,",
            "http://www.instagram.com/.*/p/.*,",
            "https://instagram.com/.*/p/.*,",
            "https://www.instagram.com/.*/p/.*,",
            "http://instagram.com/p/.*",
            "http://instagr.am/p/.*",
            "http://www.instagram.com/p/.*",
            "http://www.instagr.am/p/.*",
            "https://instagram.com/p/.*",
            "https://instagr.am/p/.*",
            "https://www.instagram.com/p/.*",
            "https://www.instagr.am/p/.*",
            "http://instagram.com/tv/.*",
            "http://instagr.am/tv/.*",
            "http://www.instagram.com/tv/.*",
            "http://www.instagr.am/tv/.*",
            "https://instagram.com/tv/.*",
            "https://instagr.am/tv/.*",
            "https://www.instagram.com/tv/.*",
            "https://www.instagr.am/tv/.*",
            "http://www.instagram.com/reel/.*",
            "https://www.instagram.com/reel/.*",
            "http://instagram.com/reel/.*",
            "https://instagram.com/reel/.*",
            "http://instagr.am/reel/.*",
            "https://instagr.am/reel/.*"
        ];
    }

    public function oEmbedUrl(): ?string
    {
        return 'https://graph.facebook.com/v16.0/instagram_oembed';
    }
}
