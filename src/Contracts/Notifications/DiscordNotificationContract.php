<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Contracts\Notifications;

interface DiscordNotificationContract
{
    /**
     * Returns a Discord-API compliant notification array.
     *
     * @param mixed $notifiable
     * @return array{
     *      contentType: 'plain'|'rich',
     *      channelId: string,
     *      message?: string, // Valid for `plain` contentType
     *      embeds?: Embed[], // Valid for `rich` contentType
     *      components?: Component[], // Valid for `components` contentType
     *      options?: array
     * }
     */
    public function toDiscord($notifiable): array;
}
