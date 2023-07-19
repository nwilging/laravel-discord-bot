<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Services\Api;

use Nwilging\LaravelDiscordBot\Contracts\Services\Api\DiscordGuildApiServiceContract;

class DiscordGuildApiService extends DiscordApiService implements DiscordGuildApiServiceContract
{
    public function getGuild(string $guildId): array
    {
        $response = $this->makeRequest(
            'GET',
            sprintf('guilds/%s', $guildId),
        );

        return json_decode($response->getBody()->getContents(), true);
    }

    public function modifyGuild(string $guildId, array $data): array
    {
        $response = $this->makeRequest(
            'PATCH',
            sprintf('guilds/%s', $guildId),
            $data,
        );

        return json_decode($response->getBody()->getContents(), true);
    }

    public function deleteGuild(string $guildId): void
    {
        $this->makeRequest(
            'DELETE',
            sprintf('guilds/%s', $guildId),
        );
    }

    public function getGuildChannels(string $guildId): array
    {
        $response = $this->makeRequest(
            'GET',
            sprintf('guilds/%s/channels', $guildId),
        );

        return json_decode($response->getBody()->getContents(), true);
    }

    public function getGuildMembers(string $guildId, array $options = []): array
    {
        // TODO: Implement getGuildMembers() method.
    }

    public function getGuildMember(string $guildId, string $userId): array
    {
        // TODO: Implement getGuildMember() method.
    }

    public function modifyGuildMember(string $guildId, string $userId, array $data): array
    {
        // TODO: Implement modifyGuildMember() method.
    }
}
