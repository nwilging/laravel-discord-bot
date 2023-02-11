<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Services;

use GuzzleHttp\ClientInterface;
use Nwilging\LaravelDiscordBot\Contracts\Services\DiscordApiServiceContract;
use Nwilging\LaravelDiscordBot\Support\Component;
use Nwilging\LaravelDiscordBot\Support\Embed;
use Nwilging\LaravelDiscordBot\Support\Traits\DiscordApiService as IsApiService;

class DiscordApiService implements DiscordApiServiceContract
{
    use IsApiService;

    public function __construct(string $token, string $apiUrl, ClientInterface $httpClient)
    {
        $this->token = $token;
        $this->apiUrl = $apiUrl;
        $this->httpClient = $httpClient;
    }

    public function sendTextMessage(string $channelId, string $message, array $options = []): array
    {
        $response = $this->makeRequest(
            'POST',
            sprintf('channels/%s/messages', $channelId),
            array_merge($this->buildMessageOptions($options), [
                'content' => $message,
            ]),
        );

        return json_decode($response->getBody()->getContents(), true);
    }

    public function sendRichTextMessage(string $channelId, array $embeds, array $components = [], array $options = []): array
    {
        $embedArrays = array_map(function (Embed $embed): array {
            return $embed->toArray();
        }, $embeds);

        $componentArrays = array_map(function (Component $component): array {
            return $component->toArray();
        }, $components);

        $response = $this->makeRequest(
            'POST',
            sprintf('channels/%s/messages', $channelId),
            array_merge($this->buildMessageOptions($options), [
                'embeds' => $embedArrays,
                'components' => $componentArrays,
            ]),
        );

        return json_decode($response->getBody()->getContents(), true);
    }

    protected function buildMessageOptions(array $options): array
    {
        return [];
    }
}
