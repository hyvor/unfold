<?php

namespace Hyvor\Unfold;

use Http\Client\Common\Plugin\HistoryPlugin;
use Http\Client\Common\Plugin\RedirectPlugin;
use Http\Client\Common\PluginClient;
use Http\Discovery\Psr18ClientDiscovery;
use Hyvor\Unfold\Link\RequestRecorder;
use Psr\Http\Client\ClientInterface;

class UnfoldConfig
{
    /**
     * A PSR-18 HTTP Client for sending oembed and other requests
     */
    public ClientInterface $httpClient;

    // These are set later in the Unfold::unfold method for internal use
    public string $url;
    public UnfoldMethod $method;

    public RequestRecorder $httpRequestRecorder;
    public float $startTime;

    public function __construct(

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
         * Meta requires an access_token to access the OEmbed Read Graph API
         * This is required for both FacebookPost & Instagram
         * @todo
         */
        public ?string $facebookAccessToken = null,

        // CACHE
    )
    {
        $this->setHttpClient($httpClient);
    }

    public function start(string $url, UnfoldMethod $method): self
    {
        $this->url = $url;
        $this->method = $method;
        $this->startTime = microtime(true);
        return $this;
    }

    private function setHttpClient(?ClientInterface $httpClient): void
    {
        $httpClient ??= Psr18ClientDiscovery::find();
        $redirectPlugin = new RedirectPlugin();

        $this->httpRequestRecorder = new RequestRecorder();
        $historyPlugin = new HistoryPlugin($this->httpRequestRecorder);

        $this->httpClient = new PluginClient(
            $httpClient,
            [
                $redirectPlugin,
                $historyPlugin,
            ],
            [
                'max_restarts' => $this->httpMaxRedirects,
            ]
        );
    }

    public function duration(): int
    {
        return (int)((microtime(true) - $this->startTime) * 1000);
    }

    public static function withUrlAndMethod(
        string $url,
        UnfoldMethod $method
    ): self {
        $config = new self();
        $config->start($url, $method);
        return $config;
    }
}
