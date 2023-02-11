<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Support\Traits;

use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;

trait DiscordApiService
{
    protected string $token;

    protected string $apiUrl;

    protected ClientInterface $httpClient;

    protected function makeRequest(string $method, string $endpoint, array $payload = [], array $queryString = []): ResponseInterface
    {
        $url = sprintf('%s/%s', $this->apiUrl, $endpoint);

        return $this->httpClient->request($method, $url, [
            'headers' => [
                'Authorization' => sprintf('Bot %s', $this->token),
            ],
            'json' => $payload,
        ]);
    }
}
