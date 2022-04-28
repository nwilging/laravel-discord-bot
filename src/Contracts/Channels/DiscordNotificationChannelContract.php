<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Contracts\Channels;

use Illuminate\Notifications\Notifiable;
use Nwilging\LaravelDiscordBot\Contracts\Notifications\DiscordNotificationContract;

interface DiscordNotificationChannelContract
{
    /**
     * Send a notification via the Discord API. The `$notification` should be an implementation of
     * the DiscordNotificationChannelContract.
     *
     * @param Notifiable $notifiable
     * @param DiscordNotificationContract $notification
     * @return array
     */
    public function send($notifiable, DiscordNotificationContract $notification): array;
}
