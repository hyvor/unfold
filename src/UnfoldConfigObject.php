<?php

namespace Hyvor\Unfold;

use GuzzleHttp\Client;
use Psr\Http\Client\ClientInterface;

class UnfoldConfigObject
{

    /**
     * A PSR-18 HTTP Client for sending oembed and other requests
     */
    public ClientInterface $httpClient;

    public function __construct(

        /**
         * UnfoldMethodEnum::LINK:
         *  - Fetch metadata of the link.
         *  - $embed is null in UnfoldedObject return
         *  - Other fields are set based on the metadata (as best as possible)
         * UnfoldMethodEnum::EMBED:
         *  - Tries to get the embed HTML using parsers (see $embedMetaFallback as well)
         *  - If fails, an error is thrown
         *  - If successful, $embed is the embed HTML
         *  - All other fields of UnfoldedObject are not set
         * UnfoldMethodEnum::LINK_EMBED:
         *  - Fetch metadata of the link, and also tries to get the embed HTML using parsers
         *  - $embed is the embed HTML is successful, otherwise null (no error thrown on failure)
         *  - All other fields are set as in the same as UnfoldMethodEnum::LINK
         */
        public UnfoldMethodEnum $method = UnfoldMethodEnum::LINK,

        /**
         * Whether to wrap the embed HTML in an iframe with `srcdoc`
         * This is useful for security and privacy reasons.
         * If set to false, the embed HTML will be directly used, which would give Javascript access to
         * the parent page.
         */
        public bool             $embedWrapInIframe = true,

        /**
         * If the $method is UnfoldMethodEnum::EMBED or UnfoldMethodEnum::EMBED_LINK,
         * and if we cannot find a way to embed the URL using our default parsers,
         * we will try to create an embed using og:image or og:video tags
         * resulting in <img> or <video> embeds.
         */
        public bool $embedMetaFallback = false,

        /**
         * A PSR-18 HTTP Client for sending oembed and other requests
         * If not set, a new GuzzleHttp\Client will be used
         */
        ?ClientInterface $httpClient = null,

        /**
         *
         */
        public ?string $iframeEndpoint = null,

        // CACHE

        // Facebook API Key
    )
    {
        $this->httpClient = $httpClient ?? new Client();
    }
}