<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Contracts\Services\Api;

interface DiscordChannelApiServiceContract
{
    public function getChannel(string $channelId): array;

    public function modifyChannel(string $channelId, array $data): array;

    public function deleteChannel(string $channelId): void;

    public function getChannelMessages(string $channelId, array $options = []): array;

    public function getChannelMessage(string $channelId, string $messageId): array;

    public function createMessage(string $channelId, array $data): array;

    public function crossPostMessage(string $channelId, string $messageId): array;
}
