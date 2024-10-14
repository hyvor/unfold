<?php

namespace Hyvor\Unfold\Oembed;

use GuzzleHttp\Client;
use Exception;

class Oembed
{
    public static function getEmbedData(array $endpoint, string $url)
    {
        $client = new Client();
        $response = $client->get($endpoint['url'], [
            'query' => ['url' => $url, 'format' => 'json']
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new Exception('Failed to get embed data');
        }

        return json_decode($response->getBody(), true);
    }

    public static function checkOembedSupport(string $url): ?array
    {
        $providers = json_decode(file_get_contents(__DIR__ . '/providers.json'), true);

        foreach ($providers as $provider) {
            foreach ($provider['endpoints'] as $endpoint) {
                foreach ($endpoint['schemes'] as $scheme) {

                    $pattern = "/^" . str_replace(['*', '/'], ['.*', '\/'], $scheme) . "$/";

                    if (preg_match($pattern, $url)) {
                        return $endpoint;
                    }
                }
            }
        }
        return null;
    }

    // No longer used in checkEmbedSupport
    public static function getProviderUrl(string $url): ?string
    {
        $pattern = '/^(https?:\/\/[^\/]+)/';
        if (preg_match($pattern, $url, $matches)) {
            return $matches[0];
        }
        return null;
    }
}