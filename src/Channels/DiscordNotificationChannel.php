<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Channels;

use Nwilging\LaravelDiscordBot\Contracts\Channels\DiscordNotificationChannelContract;
use Nwilging\LaravelDiscordBot\Contracts\Notifications\DiscordNotificationContract;
use Nwilging\LaravelDiscordBot\Contracts\Services\DiscordApiServiceContract;

class DiscordNotificationChannel implements DiscordNotificationChannelContract
{
    protected DiscordApiServiceContract $discordApiService;

    public function __construct(DiscordApiServiceContract $discordApiService)
    {
        $this->discordApiService = $discordApiService;
    }

    public function send($notifiable, DiscordNotificationContract $notification): array
    {
        $notificationArray = $notification->toDiscord($notifiable);
        switch ($notificationArray['contentType']) {
            case 'plain':
                return $this->handleTextMessage($notificationArray);
            case 'rich':
                return $this->handleRichTextMessage($notificationArray);
            default:
                throw new \InvalidArgumentException(sprintf('%s is not a valid contentType', $notificationArray['contentType']));
        }
    }

    protected function handleTextMessage(array $notificationArray): array
    {
        $channelId = $notificationArray['channelId'];
        $message = $notificationArray['message'];
        $options = $notificationArray['options'] ?? [];

        return $this->discordApiService->sendTextMessage($channelId, $message, $options);
    }

    protected function handleRichTextMessage(array $notificationArray): array
    {
        $channelId = $notificationArray['channelId'];
        $embeds = $notificationArray['embeds'] ?? [];
        $components = $notificationArray['components'] ?? [];
        $options = $notificationArray['options'] ?? [];

        return $this->discordApiService->sendRichTextMessage($channelId, $embeds, $components, $options);
    }
}
