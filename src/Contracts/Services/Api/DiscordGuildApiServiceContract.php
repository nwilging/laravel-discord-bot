<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Contracts\Services\Api;

interface DiscordGuildApiServiceContract
{
    public function getGuild(string $guildId): array;

    public function modifyGuild(string $guildId, array $data): array;

    public function deleteGuild(string $guildId): void;

    public function getGuildChannels(string $guildId): array;

    public function getGuildMembers(string $guildId, array $options = []): array;

    public function getGuildMember(string $guildId, string $userId): array;

    public function modifyGuildMember(string $guildId, string $userId, array $data): array;
}
