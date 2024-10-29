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

    // URL is later added in ->start() method
    public string $url;

    public RequestRecorder $httpRequestRecorder;
    public float $startTime;

    public function __construct(

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

        // CACHE
    )
    {
        $this->setHttpClient($httpClient);
    }

    public function start(string $url): self
    {
        $this->url = $url;
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

    public static function withUrl(string $url): self
    {
        $config = new self();
        $config->start($url);
        return $config;
    }
}
