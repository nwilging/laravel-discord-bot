<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Services\Api;

use Nwilging\LaravelDiscordBot\Contracts\Services\Api\DiscordChannelApiServiceContract;

class DiscordChannelApiService extends DiscordApiService implements DiscordChannelApiServiceContract
{
    public function getChannel(string $channelId): array
    {
        $response = $this->makeRequest(
            'GET',
            sprintf('channels/%s', $channelId),
        );

        return json_decode($response->getBody()->getContents(), true);
    }

    public function modifyChannel(string $channelId, array $data): array
    {
        $response = $this->makeRequest(
            'PATCH',
            sprintf('channels/%s', $channelId),
            $data,
        );

        return json_decode($response->getBody()->getContents(), true);
    }

    public function deleteChannel(string $channelId): void
    {
        $this->makeRequest(
            'DELETE',
            sprintf('channels/%s', $channelId),
        );
    }

    public function getChannelMessages(string $channelId, array $options = []): array
    {
        $response = $this->makeRequest(
            'GET',
            sprintf('channels/%s/messages', $channelId),
            [],
            $options,
        );

        return json_decode($response->getBody()->getContents(), true);
    }

    public function getChannelMessage(string $channelId, string $messageId): array
    {
        $response = $this->makeRequest(
            'GET',
            sprintf('channels/%s/messages/%s', $channelId, $messageId),
        );

        return json_decode($response->getBody()->getContents(), true);
    }

    public function createMessage(string $channelId, array $data): array
    {
        $response = $this->makeRequest(
            'POST',
            sprintf('channels/%s/messages', $channelId),
            $data,
        );

        return json_decode($response->getBody()->getContents(), true);
    }

    public function crossPostMessage(string $channelId, string $messageId): array
    {
        $response = $this->makeRequest(
            'POST',
            sprintf('channels/%s/messages/%s/crosspost', $channelId, $messageId),
        );

        return json_decode($response->getBody()->getContents(), true);
    }
}
