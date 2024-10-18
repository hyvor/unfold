<?php

namespace Hyvor\Unfold\Scraper;

use GuzzleHttp\Client;

class Scraper
{
    public function __construct(
        private string $url
    ) {}

    public function scrape(): string
    {
        $client = new Client();
        $response = $client->get($this->url);

        return $response->getBody();
    }
}