<?php

namespace Hyvor\Unfold;

use Http\Client\Common\Plugin\RedirectPlugin;
use Http\Client\Common\PluginClient;
use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Client\ClientInterface;

class UnfoldConfigObject
{
    /**
     * A PSR-18 HTTP Client for sending oembed and other requests
     */
    public ClientInterface $httpClient;

    public function __construct(

        /**
         * UnfoldMethod::LINK:
         *  - Fetch metadata of the link.
         *  - $embed is null in Unfolded return
         *  - Other fields are set based on the metadata (as best as possible)
         * UnfoldMethod::EMBED:
         *  - Tries to get the embed HTML using parsers (see $embedMetaFallback as well)
         *  - If fails, an error is thrown
         *  - If successful, $embed is the embed HTML
         *  - All other fields of Unfolded are not set
         * UnfoldMethod::LINK_EMBED:
         *  - Fetch metadata of the link, and also tries to get the embed HTML using parsers
         *  - $embed is the embed HTML is successful, otherwise null (no error thrown on failure)
         *  - All other fields are set as in the same as UnfoldMethod::LINK
         */
        public UnfoldMethod $method = UnfoldMethod::LINK,

        /**
         * Whether to wrap the embed HTML in an iframe with `srcdoc`
         * This is useful for security and privacy reasons.
         * If set to false, the embed HTML will be directly used, which would give Javascript access to
         * the parent page.
         */
        public bool $embedWrapInIframe = true,

        /**
         * If the $method is UnfoldMethod::EMBED or UnfoldMethod::EMBED_LINK,
         * and if we cannot find a way to embed the URL using our default parsers,
         * we will try to create an embed using og:image or og:video tags
         * resulting in <img> or <video> embeds.
         */
        public bool $embedMetaFallback = false,

        /**
         * A PSR-18 HTTP Client for sending oembed and other requests
         * If not set, HTTPPlug Discovery will be used to find a client
         * that implements PSR-18 (from composer dependencies)
         */
        ?ClientInterface $httpClient = null,

        /**
         * The maximum number of redirects to follow in HTTP requests
         * Applies to scraping and oembed requests
         * Set to 0 to disable redirects
         */
        public int $httpMaxRedirects = 3,

        /**
         * User agent string to be used in HTTP requests
         */
        public string $httpUserAgent = 'Hyvor Unfold PHP Client',

        /**
         *
         */
        public ?string $iframeEndpoint = null,

        /**
         * Meta requires an access_token to access the OEmbed Read Graph API
         * This is required for both Facebook & Instagram
         * @todo
         */
        public ?string $facebookAccessToken = null,

        // CACHE
    ) {
        $this->setHttpClient($httpClient);
    }

    private function setHttpClient(?ClientInterface $httpClient): void
    {
        $httpClient ??= Psr18ClientDiscovery::find();
        $redirectPlugin = new RedirectPlugin();

        $this->httpClient = new PluginClient(
            $httpClient,
            [$redirectPlugin],
            [
                'max_restarts' => $this->httpMaxRedirects,
            ]
        );
    }
}
