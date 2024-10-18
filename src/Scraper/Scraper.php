<?php

namespace Hyvor\Unfold\Scraper;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class Scraper
{
    private string $url;
    private string $content;

    private array $result = [];

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function getWebContent(): void
    {
        $client = new Client();
        $response = $client->get($this->url);

        $this->content = $response->getBody();
    }

    public function handle()
    {
        $this->getWebContent();

        $crawler = new Crawler($this->content);
        $crawler->filterXPath('//meta')->each(function (Crawler $node) {
            if ($node->attr('property') && str_starts_with($node->attr('property'), 'og:') && $node->attr('content')) {
                $this->result[] = [
                    $node->attr('property') => $node->attr('content')
                ];
            } elseif ($node->attr('name') && $node->attr('content')) {
                $this->result[] = [
                    $node->attr('name') => $node->attr('content')
                ];
            }
        });

//        $crawler->filterXPath('//meta[starts-with(@name, "twitter:")]')->each(function (Crawler $node) {
//            $this->result[] = [
//                $node->attr('name') => $node->attr('content')
//            ];
//        });
    }

    public function getResult(): array
    {
        return $this->result;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}